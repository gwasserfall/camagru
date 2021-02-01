import os
import unittest
import requests
import pymysql

from hashlib import sha256
from tests import config
from tests.config import session

class TestPosts(unittest.TestCase):
	def test_00_user_add_post(self):
		r = session.post(config.app_url + "/posts/add", json={
			"layers" : [config.green_square, config.red_square],
			"comment" : "Test Image"
		})

		self.assertTrue(r.json()["success"] == True, "Could not add post")

	def test_01_user_retrieve_post(self):
		r = session.get(config.app_url + "/posts/get?start=0&handle=testUser")

		self.assertTrue(len(r.json()) > 0, "Test post not added to database")

	def test_02_user_can_like_post(self):
		
		r = session.get(config.app_url + "/posts/get?start=0&handle=testUser")
		_id = r.json()[0]["id"]

		r = session.post(config.app_url + "/posts/toggle_like", json={"post_id" : _id})

		self.assertTrue(r.json()["success"], f"Could not like post {_id}")

	def test_03_user_can_unlike_post(self):
		
		r = session.get(config.app_url + "/posts/get?start=0&handle=testUser")
		_id = r.json()[0]["id"]

		r = session.post(config.app_url + "/posts/toggle_like", json={"post_id" : _id})

		self.assertTrue(r.json()["success"], f"Could not unlike post {_id}")

	def test_04_user_can_comment_on_post(self):
		r = session.get(config.app_url + "/posts/get?start=0&handle=testUser")
		_id = r.json()[0]["id"]

		r = session.post(config.app_url + "/comment/add", json={"post_id" : _id, "comment" : "Testing"})

		self.assertTrue(r.json()["success"], f"Comment could not be added to post {_id}")

	def test_05_user_can_delete_comment_on_post(self):

		db = pymysql.connect(**config.database)

		with db.cursor() as c:
			c.execute("""
			
				SELECT comments.id as id FROM comments
					LEFT JOIN users on users.id=comments.user_id
				
				 WHERE handle='testUser'
			
			""")
			comment_id = c.fetchone()["id"]

			r = session.delete(config.app_url + f"/comment/delete/{comment_id}")

			self.assertTrue(r.json()["success"])


	def test_05_user_can_delete_post(self):
		r = session.get(config.app_url + "/posts/get?start=0&handle=testUser")
		_id = r.json()[0]["id"]

		r = session.delete(config.app_url + f"/posts/delete/{_id}")

		self.assertTrue(r.json()["success"])