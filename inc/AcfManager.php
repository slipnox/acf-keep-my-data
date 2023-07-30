<?php

namespace ACFKMD\Managers;

class AcfManager {

	public static function init() {
		add_filter( 'acf/update_field', [ self::class, 'acfkmd_update_previous_stored_data' ], 99 );
	}

	public static function acfkmd_update_previous_stored_data( $field ) {
		$current_field      = (object) $field;
		$is_parent_repeater = $current_field->type === 'repeater';

		$field_from_db = get_field_object( $current_field->key );
		$field_from_db = $field_from_db ? (object) $field_from_db : false;
		$has_same_name = $field_from_db && $current_field->name === $field_from_db->name;

		if ( $has_same_name || ! $field_from_db ) {
			return $field;
		}

		$parent_field = isset( $field['parent'] )
			? (object) acf_get_field( $current_field->parent )
			: false;

		$is_repeater_child = $parent_field
		                     && property_exists( $parent_field, 'type' )
		                     && $parent_field->type === 'repeater';

		if ( $is_repeater_child ) {
			DbManager::update_new_repeater_subfield(
				$field_from_db->name,
				$current_field->name,
				$parent_field->name
			);

			return $field;
		}

		if ( $is_parent_repeater ) {
			DbManager::update_repeater_parent_name( $field_from_db->name, $current_field->name );

			return $field;
		}

		DbManager::update_acf_field_name_on_db( $field_from_db->name, $current_field->name );

		return $field;
	}
}
