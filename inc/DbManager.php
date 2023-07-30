<?php

namespace ACFKMD\Managers;

class DbManager {

	public static function update_acf_field_name_on_db($old_name, $new_name) {
		global $wpdb;

		return $wpdb->update(
			"{$wpdb->prefix}postmeta",
			['meta_key' => $new_name],
			['meta_key' => $old_name]
		);
	}

	public static function update_new_repeater_subfield(
		$old_subfield_name = '',
		$new_subfield_name = '',
		$repeater_name = ''
	) {
		global $wpdb;

		$query = $wpdb->prepare(
			"UPDATE {$wpdb->postmeta}
             SET meta_key = REPLACE(meta_key, %s, %s)
             WHERE meta_key REGEXP %s",
			$old_subfield_name,
			$new_subfield_name,
			$repeater_name . '_[0-9]+_' . $old_subfield_name
		);

		return $wpdb->query($query);
	}

	public static function update_repeater_parent_name($old_name, $new_name): void {
		global $wpdb;

		$sql = "UPDATE {$wpdb->postmeta}
            SET meta_key = REPLACE(meta_key, %s, %s)
            WHERE meta_key LIKE %s";

		$wpdb->query(
			$wpdb->prepare($sql, $old_name, $new_name, '%' . $wpdb->esc_like($old_name) . '%')
		);
	}
}
