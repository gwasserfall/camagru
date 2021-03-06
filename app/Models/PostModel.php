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
			return false;
		}
	}

	public function getPostbyId($id)
	{
		$sql = "
		SELECT
			posts.id as id,
			users.id as user_id,
			notifications as notify,
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
			return false;
		}
	}

	public function retrieve($start=0, $handle=NULL)
	{
		$sql_base = "
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
		";

		if ($handle)
			$sql_base .= " WHERE users.handle=:handle ";

		$sql_base .= "ORDER BY date DESC LIMIT :start,12";

		$stmt = $this->db->prepare($sql_base);
		
		if ($handle)
			$stmt->bindValue(":handle", $handle);
		
		$stmt->bindValue(":start", (int)$start, PDO::PARAM_INT);
		
		try
		{    
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$t = $stmt->rowCount();

			return $data;
		}
		catch (PDOException $e)
		{;
			return false;
		}
	}

	public function deletePostById($id)
	{
		$sql = "DELETE FROM posts WHERE id=:id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
		try
		{    
			return $stmt->execute();
		}
		catch (PDOException $e)
		{
			return false;
		}
	}
}