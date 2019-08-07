<?php 
//ADD NEW ROLE
add_role('client', __(
	'Client'),
	array(
			'read'              => true, // Allows a user to read
			'create_posts'      => false, // Allows user to create new posts
			'edit_posts'        => false, // Allows user to edit their own posts
			'edit_others_posts' => false, // Allows user to edit others posts too
			'publish_posts'     => false, // Allows the user to publish posts
			'manage_categories' => false, // Allows user to manage post categories
			)
);

add_role('manager', __(
	'Manager'),
	array(
			'read'              => true, // Allows a user to read
			'create_posts'      => true, // Allows user to create new posts
			'edit_posts'        => true, // Allows user to edit their own posts
			'edit_others_posts' => true, // Allows user to edit others posts too
			'publish_posts'     => true, // Allows the user to publish posts
			'manage_categories' => false, // Allows user to manage post categories
	'edit_private_posts'=> true,
	'create_users'	=> true,
	
			)
);

//REMOVE ROLES
remove_role( 'subscriber' );
remove_role( 'contributor' );
remove_role( 'author' );
remove_role( 'editor' );
remove_role( 'supervisor' );
?>