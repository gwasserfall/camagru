class CamagruCanvas extends HTMLCanvasElement {
	constructor() {

	  super();

	  this.image = null
	  this.image_x = 0
	  this.image_y = 0
	  this.click_x = 0
	  this.click_y = 0
	  this.scale = 1
	  this.is_draggable = false
	  this.is_active = false
	  this.is_base = false
	  this.ctx = this.getContext("2d")
  
	  this.onmousedown = this.handleMouseDown
	  this.onmousemove = this.handleMouseMove
	  this.onmouseup = this.handleMouseUp
	  this.onwheel = this.handleWheel
  
	}


	addVideoSnap(stream)
	{
		var tempCanvas = document.createElement("canvas")
		tempCanvas.height = 600
		tempCanvas.width = 600
		
		var t_ctx = tempCanvas.getContext("2d")

		t_ctx.drawImage(stream, 0, 0)


		this.addImage(tempCanvas.toDataURL())

	}


	addImage(source)
	{
		this.image = new Image

		this.image.onload = () => {
			this.draw()
		}
		this.image.src = source
	}

	mouseOverImage(event)
	{
		var bound = this.getBoundingClientRect()
		var mouseX = event.clientX - bound.x;
		var mouseY = event.clientY - bound.y;

		if (mouseX >= this.image_x && mouseX <= this.image_x + (this.image.width) * this.scale)
		{
			if (mouseY >= this.image_y && mouseY <= this.image_y + (this.image.height * this.scale))
			{
				return true
			}
		}
		return false
	}

	handleWheel(event)
	{
		if (this.mouseOverImage(event))
		{
			event.preventDefault()
			if (event.deltaY > 0)
				this.scale -= 0.03
			else
				this.scale += 0.03
			
			if (this.scale < 0.05)
				this.scale = 0.05
			this.draw()
		}
	}

	handleMouseDown(event)
	{
		if (!this.image)
			return false

		this.click_x = (event.clientX - this.image_x);
		this.click_y = (event.clientY - this.image_y);

		if (this.mouseOverImage(event))
			this.is_draggable = true
	}
  
	handleMouseUp(event)
	{
		this.is_draggable = false
	}
  
	handleMouseMove(event)
	{
		if (!this.image)
			return false

		if (this.is_draggable) {
			this.image_x = ((this.click_x - event.clientX)) * -1
			this.image_y = ((this.click_y - event.clientY)) * -1
			this.draw()
		}
	}
  
	activate()
	{
		document.querySelectorAll("canvas").forEach(el => {
			if (el instanceof CamagruCanvas) 
			{
				el.is_active = false
				el.style.zIndex = (this.is_base) ? 0 : 1;
				console.log(this.is_base, this.id)
				el.draw()
			}
		})
		this.is_active = true
		this.style.zIndex = (this.is_base) ? 0 : 2;
		this.draw()
	}
  
	draw()
	{
		if (this.image)
		{
			this.ctx.clearRect(0,0, this.width, this.height);
			this.ctx.drawImage(this.image, this.image_x, this.image_y, 
				this.image.width * this.scale, this.image.height * this.scale)

			if (this.is_active)
			{
				this.ctx.beginPath();
				this.ctx.rect(this.image_x - 5, this.image_y - 5, 
					(this.image.width * this.scale) + 10, (this.image.height * this.scale) + 10);
				this.ctx.stroke();
				this.style.zIndex = 1
			}
		}
	}
}

customElements.define('camagru-canvas', CamagruCanvas, { extends: 'canvas' });