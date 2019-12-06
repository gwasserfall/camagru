<?= Component::load("GlobalHeader", ["title" => "Sign Up"]) ?>
<body>
<?php Component::load("Desktop/GenericHeader-desktop") ?>

<style>
.right-inner-addon {
    position: relative;
}

.right-inner-addon img {
    position: absolute;
    right: 0px;
    padding: 10px 12px;
	height: 100%;
	filter: opacity(50%);
}
</style>

<div class="columns is-centered" style="margin-top: 3rem">
	<div class="column is-6">

		<div class="slide-container">
			<div class="box slide center">
				<form id="new_user">
				
				<div class="field is-horizontal">
					<div class="field-label grow-1 is-normal">
						<label class="label">Email</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded">
								<input id="email-field" name="email" class="input" type="email">
							</p>
							<p id="email-field-info" class="help is-danger"></p>
						</div>
					</div>
				</div>

				<div class="field is-horizontal">
					<div class="field-label grow-1 is-normal">
						<label class="label">Password</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded right-inner-addon">
								<input id="password-field" 
										name="password" 
										class="input" 
										type="password"
										minlength="8"
										maxlength="32">
								<img class="show-password" src="/img/icons8-show-password-48.png">
							</p>
							<p id="password-field-info" class="help is-danger"></p>
						</div>
					</div>
				</div>

				<div class="field is-horizontal">
					<div class="field-label grow-1 is-normal">
						<label class="label">Repeat</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control right-inner-addon">
								<input id="repeat-password-field" 
										class="input" 
										type="password"
										minlength="8"
										maxlength="32">
								<img class="show-password" src="/img/icons8-show-password-48.png">
							</p>
							<p id="repeat-field-info" class="help is-danger"></p>
						</div>
					</div>
				</div>

				<div class="box has-background-warning has-text-centered">
				A password should be <strong>8 to 32 characters</strong> in length and <strong>contain at least</strong>:<br/> 
				a <strong>special character</strong>,
				a <strong>number</strong>, a <strong>lowercase letter</strong> and an <strong>uppercase letter</strong>.
				</div>

				<div class="buttons">
					<div class="spacer"></div>
					<button id="next-button" type="button" class="button is-primary" onclick="nextSlide()" disabled>Next</button>
				</div>

			</div>
			<div id="slide-right" class="box slide right">

				<div class="field is-horizontal">
					<div class="field-label grow-1 is-normal">
						<label class="label">Handle</label>
					</div>
					<div class="field-body">
						<div class="field is-expanded">
						<div class="field has-addons">
							<p class="control">
								<a class="button is-static">@</a>
							</p>
							<p class="control is-expanded">
								<input name="handle" id="handle" class="input" type="password">
							</p>
						</div>
						<p id="handle-field-info" class="help is-danger"></p>
						</div>
					</div>
				</div>

				<div class="field is-horizontal">
					<div class="field-label grow-1 is-normal">
						<label class="label">First Name</label>
					</div>
					<div class="field-body">
						<div class="field">
						<p class="control is-expanded">
							<input name="first_name" class="input" type="text" name="first_name" required>
						</p>
						</div>
					</div>
				</div>

				<div class="field is-horizontal">
					<div class="field-label grow-1 is-normal">
						<label class="label">Last Name</label>
					</div>
					<div class="field-body">
						<div class="field">
						<p class="control is-expanded">
							<input name="last_name" class="input" type="text">
						</p>
						</div>
					</div>
				</div>

				<div class="buttons">
					<button type="button" class="button is-light" onclick="previousSlide()">Back</button>
					<button type="button" class="button is-primary" disabled onclick="createUser('new_user')">Sign Up</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="/js/signup.js"></script>

<?php Component::load("Desktop/GenericFooter-desktop") ?>
</body>
<?= Component::load("GlobalFooter") ?>