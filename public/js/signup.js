var currentSlide = 0;
var slides = document.querySelectorAll(".slide")
var count = slides.length

disable_tab_indeces(slides[1])

function disable_tab_indeces(slide)
{
	slide.querySelectorAll("input").forEach(el => {
		el.tabIndex = -1
	})

	slide.querySelectorAll("button").forEach(el => {
		el.tabIndex = -1
	})
}

function enable_tab_indeces(slide)
{
	var i = 1
	slide.querySelectorAll("input").forEach(el => {
		el.tabIndex = i++
	})

	slide.querySelectorAll("button").forEach(el => {
		el.tabIndex = i++
	})
}

function nextSlide()
{
	slides[currentSlide].classList.remove("center")
	slides[currentSlide].classList.add("left")
	disable_tab_indeces(slides[currentSlide])
	currentSlide++;
	slides[currentSlide].classList.remove("right")
	slides[currentSlide].classList.add("center")
	enable_tab_indeces(slides[currentSlide])
}

function previousSlide()
{
	slides[currentSlide].classList.remove("center")
	slides[currentSlide].classList.add("right")
	disable_tab_indeces(slides[currentSlide])
	currentSlide--;
	slides[currentSlide].classList.remove("left")
	slides[currentSlide].classList.add("center")
	enable_tab_indeces(slides[currentSlide])
}

document.getElementById("handle").addEventListener("keypress", event => {
	if ([" ", "/", "."].includes(event.key))
		event.preventDefault()
	event.target.classList.remove("is-danger")
})

function createUser(formId)
{
	ApiClient.createUser(formId)
	.then(data => {
		if (data.success)
			window.location.href = "/login";
	})
	.catch(err => {
		Messages.error(err.message)
    })
}

function validate_email(event)
{
	this.classList.add("is-danger")
	if (this.value.length > 3)
	{
		let info = document.getElementById("email-field-info")
		if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value))
		{
			info.innerText = ""
			this.classList.remove("is-danger")
			this.classList.add("is-success")
		}
		else
		{
			info.innerText = "This email is not valid"
		}
		validate_first_slide()
	}
}

function validate_password(event)
{
	this.classList.add("is-danger")

	let repeat = document.getElementById("repeat-password-field")

	repeat.value = ""
	let messages = []
	if (this.value.length > 3)
	{
		let info = document.getElementById("password-field-info")

		if (this.value.length < 8)
		{
			messages.push("Password must be at least 8 characters")
		}

		if (this.value.length > 32)
		{
			messages.push("Password must be 32 characters or less")
		}
		
		if (!/[A-Z]/.test(this.value))
		{
			messages.push("At least 1 uppercase letter required A-Z")
		}

		if (!/[a-z]/.test(this.value))
		{
			messages.push("At least 1 lowercase letter required a-z")
		}

		if (!/[\'^£!$%&*()}{@#~?><>,|=_+¬-]/.test(this.value))
		{
			messages.push("At least 1 special character required '^£!$%&*()}{@#~?><>,|=_+¬-")
		}

		if (!/[0-9]/.test(this.value))
		{
			messages.push("At least 1 number required 0-9")
		}

		if (messages.length > 0)
		{
			info.innerHTML = messages.join("<br>")
		}
		else
		{
			info.innerText = ""
			this.classList.remove("is-danger")
			this.classList.add("is-success")
		}
		validate_first_slide()
	}
}

function validate_password_repeat()
{
	let password = document.getElementById("password-field")
	let info = document.getElementById("repeat-field-info")
	
	this.classList.add("is-danger")
	
	if (this.value.length > 3)
	{
		if (password.classList.contains("is-danger"))
		{
			info.innerText = "Above password is not valid"
			return false
		}

		if (password.value != this.value)
		{
			info.innerText = "Passwords to not match"
		}
		else
		{
			info.innerText = ""
			this.classList.remove("is-danger")
			this.classList.add("is-success")
		}
		validate_first_slide()
	}
}


function validate_first_slide()
{
	var valid = true
	var next = document.getElementById("next-button")
	let fields = [
		document.getElementById("repeat-password-field"),
		document.getElementById("password-field"),
		document.getElementById("email-field")]

	fields.forEach(field => {
		if (field.classList.contains("is-danger") || field.value.length < 3)
			valid = false
	})

	next.disabled = !valid;
}

function validate_handle(event)
{
	this.classList.add("is-danger")
	let info = document.getElementById("handle-field-info")

	if (this.value.length > 3)
	{
		if (/^[a-zA-Z0-9_-]*$/.test(this.value))
		{
			info.innerText = ""
			this.classList.remove("is-danger")
			this.classList.add("is-success")
		}
		else
		{
			info.innerText = "Invalid character in handle. Valid characters are A-Z a-z 0-9 - _"
		}
	}
}

document.getElementById("handle").oninput = validate_handle
document.getElementById("repeat-password-field").oninput = validate_password_repeat
document.getElementById("password-field").oninput = validate_password
document.getElementById("email-field").oninput = validate_email


