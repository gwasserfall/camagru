<?php

class PostModel extends BaseModel
{
	public function create($post)
	{
		$sql = "
			INSERT INTO posts 
				(user_id, image, comment)
			VALUES
				(:user_id, :image, :comment)";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":user_id", $post["user_id"]);
		$stmt->bindParam(":image", $post["image"]);
		$stmt->bindParam(":comment", $post["comment"]);
		
		try
		{    
			return $stmt->execute();
		}
		catch (PDOException $e)
		{
			error_log("SQL Error: " . $e->getMessage(),0);
			return false;
		}
	}

	public function getPostbyId($id)
	{
		$sql = "
		SELECT
			posts.id as id,
			first_name, 
			last_name, 
			handle, 
			email,
			date,
			image,
			(SELECT COUNT(*) FROM likes WHERE post_id=posts.id) AS like_count,
			(SELECT COUNT(*) FROM comments WHERE post_id=posts.id) AS comment_count
		FROM posts
			LEFT JOIN users ON users.id=posts.user_id
		WHERE
			posts.id =:postid
		";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":postid", $id);
		try
		{    
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			error_log("SQL Error: " . $e->getMessage(),0);
			return false;
		}
	}

	public function retrieve($start=0, $handle=NULL)
	{
		$sql = "
			SELECT
				posts.id as id,
				first_name, 
				last_name, 
				handle, 
				email,
				date,
				image,
				(SELECT COUNT(*) FROM likes WHERE post_id=posts.id) AS like_count,
				(SELECT COUNT(*) FROM comments WHERE post_id=posts.id) AS comment_count
			FROM posts
				LEFT JOIN users ON users.id=posts.user_id
			LIMIT :ll,15
		";

		$right_limit = $start + 15;

		error_log("Start $start end $right_limit");

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":ll", $start, PDO::PARAM_INT);
		// $stmt->bindParam(":lr", $right_limit, PDO::PARAM_INT);

		try
		{    
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$t = $stmt->rowCount();

			error_log("Returned $t", 0);

			return $data;
		}
		catch (PDOException $e)
		{
			error_log("SQL Error: " . $e->getMessage(),0);
			return false;
		}

	}
}