<?php
/**
* Plugin Name: Reservation
* Version: 1.0
* Author: Melissande
* Description: add an activity plugin for Optimum
*/


// create table activity
function activity_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'activity';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id_activity mediumint(9) NOT NULL AUTO_INCREMENT,
        name_activ varchar(55) NOT NULL,
        num_person int,
        price int,
        PRIMARY KEY  (id_activity)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('activity_db_version', '1.0');
}
register_activation_hook(__FILE__, 'activity_db');


// create table reserve
function reserve_db() {
    global $wpdb;
    $table_name1 = $wpdb->prefix . 'activity';
    $table_name = $wpdb->prefix . 'reserve';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id_reserve mediumint(9) NOT NULL AUTO_INCREMENT,
        res_id_activity mediumint(9) NOT NULL,
        res_name varchar(55) NOT NULL,
        res_age varchar(55) NOT NULL,
        res_email varchar(20) NOT NULL,
        res_phone varchar(6) NOT NULL,
        res_day varchar(55) NOT NULL,
        res_hour varchar(55) NOT NULL,
        res_total int,
        PRIMARY KEY  (id_reserve),
        FOREIGN KEY (res_id_activity) REFERENCES ".$table_name1."(id_activity)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('reserve_db_version', '1.0');
}
register_activation_hook(__FILE__, 'reserve_db');


// insert activity into db
function insert_activity_db() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'activity';
    
    $wpdb->insert($table_name, array(
        'name_activ' => 'Yoga',
        'num_person' => 20,
        'price' => 1000
    ));
}
register_activation_hook(__FILE__, 'insert_activity_db');


// display activity form in wordpress
function add_activity_to_admin() {


    // get activities content from db
	function activity_content() {
		echo "<h1>Activity</h1>";
		echo "<div style='margin-right:20px'>";

		if(class_exists('WP_List_Table')) {
			require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
			require_once(plugin_dir_path( __FILE__ ) . 'reservation-list-table.php');
                $activityListTable = new ActivityListTable();
			    $activityListTable->prepare_items();
			    $activityListTable->display();
		} else {
			echo "WP_List_Table n'est pas disponible.";
		}
		
		echo "</div>";
	}
    
	add_menu_page('Activities', 'Activities', 'manage_options', 'activity-plugin', 'activity_content');
    
    // Add activity form in wordpress
    function activity_form() {

        if (isset($_POST['activity'])) {
            $name_activ = sanitize_text_field($_POST["name_activ"]);
            $num_person = sanitize_text_field($_POST["num_person"]);
            $price = sanitize_text_field($_POST["price"]);
        
            if ($name_activ != '' && $num_person  != '' && $price  != '') {
            	
                global $wpdb;
        
            	$table_name = $wpdb->prefix . 'activity';
            	$wpdb->insert($table_name, array( 
            			'name_activ' => $name_activ,
                        'num_person' => $num_person,
                        'price' => $price
            		) 
            	);
            }
        }
        
        echo "<h1>Insert your activity</h1>
        <form method='POST'>
            <div style='padding-bottom:10px'>
                <label for='name_activ'>Nom de l'activité :
                <input type='text' name='name_activ' placeholder='Activité' required></label></br>
            </div>
            <div style='padding-bottom:10px'>
                <label for='num_person'>Nombre de places :
                <input type='text' name='num_person' placeholder='Nombre' required></label></br>
            </div>
            <div style='padding-bottom:10px'>
                <label for='price'>Tarif :
                <input type='text' name='price' placeholder='montant' required></label></br>
            </div>
            <input type='submit' name='activity' value='Envoyer'>
        </form>";


    }

    add_submenu_page('activity-plugin', 'Activity', 'Ajouter', 'edit_posts', 'activity-create', 'activity_form');
    
}
add_action('admin_menu', 'add_activity_to_admin');


// display reservation form in front
// adding bootstrap in <head> of your theme before using this
function show_reserve_form() {
    
    ob_start();

    global $wpdb;
    $table_name1 = $wpdb->prefix . 'activity';
    $activities = $wpdb->get_results("SELECT * FROM $table_name1", ARRAY_A);

    if (isset($_POST['reserve'])) {
        $res_id_activity = $_POST["res_id_activity"];
        $res_name = sanitize_text_field($_POST["res_name"]);
        $res_age = sanitize_text_field($_POST["res_age"]);
        $res_email = sanitize_text_field($_POST["res_email"]);
        $res_phone = sanitize_text_field($_POST["res_phone"]);
        $res_day = sanitize_text_field($_POST["res_day"]);
        $res_hour = sanitize_text_field($_POST["res_hour"]);
   
        if ($res_name != '' && $res_age != '' && $res_email  != '' && $res_phone  != '' && $res_day  != '' && $res_hour  != '') {
            global $wpdb;
    
            $table_name = $wpdb->prefix . 'reserve';
            $wpdb->insert($table_name, 
                array( 
                    'res_id_activity' => $res_id_activity,
                    'res_name' => $res_name,
                    'res_age' => $res_age,
                    'res_email' => $res_email,
                    'res_phone' => $res_phone,
                    'res_day' => $res_day,
                    'res_hour' => $res_hour,
                ) 
            );

            echo "<h6 class='text-success'>Votre demande a été prise en compte !</h6>";
        } else {
            echo "<h6 class='text-danger'>Une erreur s'est produite !</h6>";
        }
    }
    
    echo "
        <div id='form-reserve'>
            <h5>Réservez un cours / une séance</h5>
            <form method='POST'>
                <div class='row'>
                    <div class='col-6 pb-3'>
                        <input type='text' name='res_name' placeholder='Prénom et nom' required></label></br>
                    </div>
                    <div class='col-6 pb-3'>
                        <input type='text' name='res_age' placeholder='Age' required></label></br>
                    </div>
                    <div class='col-6 pb-3'>
                        <input type='email' name='res_email' placeholder='Email' required></label></br>
                    </div>
                    <div class='col-6 pb-3'>
                        <input type='text' name='res_phone' placeholder='Téléphone' required></label></br>
                    </div>
                    <div class='col-6 pb-3'>
                        <label for='res_id_activity'>Selectionner une activité </label>
                        <select name='res_id_activity' required>";
                        foreach ($activities as $activity) {
                            echo "<option value='" . $activity['id_activity'] . "' " . (isset($activity) && $activity->res_id_activity == $activity['id_activity'] ? "selected" : "") . ">" . $activity['name_activ'] . "</option>";
                        }
                        echo "</select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col pb-3'>
                        <label for='res_day'>Jour et heure de semaine </label>
                        <select name='res_day' required>
                            <option value='lundi'>lundi</option>
                            <option value='mardi'>mardi</option>
                            <option value='mercredi'>mercredi</option>
                            <option value='jeudi'>jeudi</option>
                            <option value='vendredi'>vendredi</option>
                        </select>
                        <select name='res_hour' required>
                            <option value='8:00-10:00'>8:00-10:00</option>
                            <option value='11:00-13:00'>11:00-13:00</option>
                            <option value='14:00-15:00'>14:00-15:00</option>
                            <option value='16:30-18:30'>16:30-18:30</option>
                            <option value='19:30-21:00'>19:30-21:00</option>
                        </select>
                    </div>
                </div>
                <input type='submit' name='reserve' value='Envoyer'>
            </form>
        </div>";
    
    return ob_get_clean();
}
add_shortcode('form_reserve', 'show_reserve_form');

// display all activities in front 
function all_activities() {
    
    ob_start();

    global $wpdb;
    $table_name1 = $wpdb->prefix . 'activity';
    $activities = $wpdb->get_results("SELECT * FROM $table_name1", ARRAY_A);

    // random image
    $images[0]="https://images.unsplash.com/photo-1516481265257-97e5f4bc50d5?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8Y3Jvc3MlMjB0cmFpbmluZ3xlbnwwfHwwfHw%3D&w=1000&q=80";
    $images[1]="https://media.istockphoto.com/photos/closeup-of-weightlifter-clapping-hands-before-barbell-workout-a-picture-id601902710?k=20&m=601902710&s=612x612&w=0&h=Pg3BNIuBviyVaXmwfWYK73ip6KwuFQq-nVtjH0Dnk2Q=";
    $i = rand(0, 1);

    if($activities != null) {
        echo '
        <div class="container">
            <div class="row justify-content-md-center">';
                foreach ($activities as $activity) {
                    echo '
                    <div class="col-6 col-md-4 d-flex">
                        <div class="card border border-5 mb-3 m-2" style="max-width:25rem;">
                            <div class="card-header text-center">
                                <img src="' .$images[$i]. '" alt="image" width="600" height="300" style="width:600px;height:300px;object-fit:cover;">
                            </div>
                            <div class="card-body text-center">';
                                echo "<h6 class='card-title'>".$activity['name_activ']."</h6>
                                <p class='card-text mb-0'><span>Nombre de personnes : ".$activity['num_person']."</span></p>
                                <p class='card-text'><em style='font-size:10px;'>Prix </em><span>".$activity['price']." XPF par semaine</span></p>
                            </div>
                            <div class='card-footer d-flex'>
                                <div class='mx-auto'>
                                    <a href='http://localhost/wordpress/#form-reserve' style='text-decoration: none;'><button type='button' class='btn btn-primary rounded-pill m-2' style='padding: 5px 30px'>Je choisi !</button></a>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            echo '
            </div>
        </div>';
    } else {
        echo '<div style="color:white">Cette section est vide</div>';
    }
    
    return ob_get_clean();
}
add_shortcode('all_activities', 'all_activities');

