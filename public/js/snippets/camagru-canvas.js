
// interact with camagru canvas here

var viewPanel = document.getElementById("view")
var fileInput = document.getElementById("file-in")
var stickers = document.getElementById("stickers")
var webStream = null
var layers = document.getElementById("layers")
var counter = 0;
var cameraReady = false

window.addEventListener("DOMContentLoaded", () => {
	setInterval(() => {
		var hasBase = false
		let button = document.getElementById("save-post")
		
		document.getElementById("layers").querySelectorAll(".layer").forEach(el => {
			if (el.innerText === "base")
				hasBase = true
		})
		button.disabled = !hasBase
	}, 500);
})


ApiClient.getStickers()
	.then(resp => {
		
		if (resp.success)
		{
			resp.data.forEach(sticker => {
				var img = new Image	
				img.src = sticker.image
				img.class = "sticker"
				img.id = sticker.name
				img.onclick = stickerClicker
				stickers.appendChild(img)
			});
		}
		else
		{
			Messages.error(resp.message)
		}
	})


function stickerClicker(event)
{
	counter++;
	newLayer(this.src, `${this.id}-${counter}`)
}


function newLayer(src, id = "sticker")
{
	var canvas = document.createElement("canvas", {is : "camagru-canvas"})
	
	canvas.width = 600
	canvas.height = 600
	canvas.style.zIndex = 1
	canvas.id = id
	canvas.is_base = (id === "base")

	if (src instanceof HTMLVideoElement)
		canvas.addVideoSnap(src)
	else
		canvas.addImage(src)
	canvas.activate()

	if (canvas.is_base)
	{
		viewPanel.prepend(canvas)
		addLayerEntryBefore(id)
	}
	else
	{
		viewPanel.appendChild(canvas)
		addLayerEntry(id)
	}
}



function addLayerEntry(name)
{
	var div = document.createElement("div")
	var button = document.createElement("button")

	div.className = "layer"
	button.className = "delete"

	button.onclick = function (event) 
	{
		document.getElementById(name).remove()
		div.remove()
		event.stopPropagation()
	}

	div.onclick = function ()
	{
		document.querySelectorAll("canvas").forEach(canvas => {
			canvas.is_active = false
			canvas.style.zIndex = 1;
			canvas.draw()
		})

		let cnv = document.getElementById(name)
		cnv.is_active = true
		cnv.style.zIndex = 2;
		cnv.draw()
	}

	div.innerText = name
	div.appendChild(button)
	layers.appendChild(div)	
}

function addLayerEntryBefore(name)
{
	var div = document.createElement("div")
	var button = document.createElement("button")

	div.className = "layer"
	button.className = "delete"

	div.onclick = function ()
	{
		document.querySelectorAll("canvas").forEach(canvas => {
			canvas.is_active = false
			canvas.style.zIndex = 1;
			canvas.draw()
		})

		let cnv = document.getElementById(name)
		cnv.is_active = true
		cnv.style.zIndex = 2;
		cnv.draw()
	}

	div.innerText = name
	layers.prepend(div)
}

function uploadFile(el)
{
	el.classList.add("is-primary")
	document.getElementById("selfie-button").classList.remove("is-primary")
	document.getElementById("stickers").style.display = ""

	killVideo()
	fileInput.click()
}

function killVideo()
{
	if (webStream)
	{
		webStream.getTracks()[0].stop()
		webStream = null
	}
}

function removeBaseLayer()
{
	var base = document.getElementById("base")
	if (base)
		base.parentElement.removeChild(base)

	document.querySelectorAll(".layer").forEach(el => {
		console.log(el)
		if (el.innerText === "base")
			el.parentNode.removeChild(el)
	})
	

	// Disable post button
	document.getElementById("save-post").disabled = true
}

fileInput.onchange = function(event)
{
	if (this.files.length > 0)
	{
		removeBaseLayer()
		newLayer(URL.createObjectURL(this.files[0]), "base")

		// Enable post button
		document.getElementById("save-post").disabled = false

		killVideo()
	}
	else
	{
		document.getElementById("upload-button").classList.remove("is-primary")
	}
}

function snapshot(el)
{
	el.disabled = true
	el.classList.remove("is-primary")
	document.getElementById("selfie-button").classList.remove("is-primary")

	if (webStream)
	{	
		var video = document.querySelector("video")
		removeBaseLayer()
		newLayer(video, "base")
		killVideo()
	}
	else
	{
		Messages.info("Webcam not ready, please reload the page.")
	}
}

function webcam(el)
{
	removeBaseLayer()
	var video = document.createElement("video")

	el.classList.add("is-primary")
	document.getElementById("upload-button").classList.remove("is-primary")
	document.getElementById("stickers").style.display = ""

	video.autoplay = true
	video.id = "base"

	cameraReady = true

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({ video: { width: 600, height: 600 } })
		  .then(function (stream) {
				webStream = stream
				video.srcObject = stream;
				return new Promise(resolve => video.onloadedmetadata = resolve);
		  })
		  .then(function () {
				let button = document.getElementById("capture-button")
				button.classList.add("is-primary")
				button.disabled = false
				cameraReady = true
		  })
		  .catch(function (error) {
			Messages.error(error);
		  });
	  }
	viewPanel.appendChild(video)
}