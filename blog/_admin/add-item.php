<?php

	// include
	require '../_inc/config.php';

	// just to be safe
	if ( ! logged_in() ) {
		redirect('/');
	}


	// validation
	if ( ! $data = validate_post() ) {
		redirect('back');
	}

	extract( $data );
	$slug = slugify( $title );

	$query = $db->prepare("
		INSERT INTO posts
			( user_id, title, text, slug )
		VALUES
			( :uid, :title, :text, :slug )
	");

	$insert = $query->execute([
		'uid'   => get_user()->uid,
		'title' => $title,
		'text'  => $text,
		'slug'  => $slug
	]);


	if ( ! $insert )
	{
		flash()->warning( 'sorry' );
		redirect('back');
	}


	// great success!
	$post_id = $db->lastInsertId();


	// if have tags, add them
	if ( isset( $tags ) && $tags = array_filter( $tags ) )
	{
		foreach ( $tags as $tag_id )
		{
			$insert_tags = $db->prepare("
				INSERT INTO posts_tags
				VALUES (:post_id, :tag_id)
			");

			$insert_tags->execute([
				'post_id' => $post_id,
				'tag_id'  => $tag_id
			]);
		}
	}

	// let's visit the new post
	flash()->success( 'new one!' );

	redirect(get_post_link([
		'id'   => $post_id,
		'slug' => $slug,
	]));
