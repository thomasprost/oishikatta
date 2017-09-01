let rotateText = function () {
    const mainMenu = document.querySelector("#main-menu"), menuRot = document.querySelectorAll("#site-name > i");
    let currentAngle = 0, isHover = false;
    const step = 360 / menuRot.length ;

    mainMenu.addEventListener('mouseenter', function(){
        if(!isHover){
            menuRot.forEach((el,i) => {
                el.style.transform = `rotateX(${ currentAngle + i*step }deg) translateZ(-25px)`
            })
            currentAngle += step
            isHover = true
        }
    })

    mainMenu.addEventListener('mouseleave', function() {
            isHover = false
        }
    )
}

export default rotateText;