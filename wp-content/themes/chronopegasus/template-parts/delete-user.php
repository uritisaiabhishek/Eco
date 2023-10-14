<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_form']) ) {
        $user_id = $_POST['user_id'];
        global $wpdb;

        $query = $wpdb->prepare("DELETE FROM $wpdb->users WHERE ID = %d", $user_id);
        $wpdb->query($query); 
        $query = $wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE user_id = %d", $user_id);
        $wpdb->query($query);
        
        $_SESSION['message'] = 'User deleted successfully';
        $_SESSION['status'] = 'status';
    }
?>