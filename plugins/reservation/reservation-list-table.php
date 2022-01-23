<?php
/**
 * 
 * Class to have a table of activity list.
 * 
 */
class ActivityListTable extends WP_List_Table
{
    public function get_data() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'activity';
		return $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
	}

    public function get_columns()
    {
        return array(
            'id_activity' => 'Identifiant',
            'name_activ' => 'Nom',
            'num_person' => 'Nombre de personnes'
        );
    }

    public function column_default($items, $column_name) {
        return $items[$column_name];
    }

    public function prepare_items()
    {
        $data = $this->get_data();
        $columns = $this->get_columns();
        $this->_column_headers = array($columns, array());
        $this->items = $data;
    }
}