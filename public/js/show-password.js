document.addEventListener("DOMContentLoaded", e => {
    document.querySelectorAll(".show-password").forEach(el => {
        var input = el.parentNode.querySelector("input")

        el.onclick = function(event)
        {
            el.src = "/img/icons8-hide-48.png"
            input.type = "text"
        }

        el.parentElement.onmouseleave = function()
        {
            let inp = this.parentNode.querySelector("input")
            document.querySelectorAll(".show-password").forEach(img => {
                img.src = "/img/icons8-show-password-48.png"
                inp.type = "password"
            })
        }
    })
})