<?php 

class SignupController extends BaseController
{
	public $allowedRoutes = [
        "default",
		"create",
	];

	public function __construct($name, $args)
	{
		parent::__construct($name, $args);
		$this->model = new UserModel();
	}

	public function default()
	{
		RenderView::file("SignUp");
	}

	// JSON endpoint
	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$data = $this->getJSON();

			$missing = $this->keysMissing($data, ["email", "handle", "password", "first_name"]);
			if ($missing)
				RenderView::json([], 400, "Field '$missing' cannot be blank.");

			if (!Validate::password($data["password"]))
				RenderView::json([], 400, "Password does not meet complexity requirements.");

			$handle = $this->model->getUserByHandle($data["handle"]);
			$email = $this->model->getUserByEmail($data["email"]);

			if (strlen($data["first_name"]) < 2)
				RenderView::json([], 400, "Firstname must be atleast 2 characters.");

			if ($handle != FALSE)
				RenderView::json([], 400, "Handle already exists.");

			if ($email != FALSE)
				RenderView::json([], 400, "Email address already exists.");

			if ($this->model->create($data))
			{
				$user = $this->model->getUserByEmail($data["email"]);

				$link = SERVER_ADDRESS . "users/verify/" . $user["id"] . "/" . hash("sha256", $data["email"] . SALT);
				$name = $user["first_name"];
				Email::send_verification_email($name, $user["email"], $link);

				RenderView::json([], 200, "User created successfully, please check your email to verify your account");
			}
			else
				RenderView::json([], 400, "Failed to create user");
		}
		else
		{
			RenderView::json([], 400, "method {$_SERVER['REQUEST_METHOD']} not allowed");
		}
	}
}