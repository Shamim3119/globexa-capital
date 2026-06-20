function fadeToggle(btnNew, divNew, divView) {
    const boxNew = document.getElementById(divNew);
    const boxView = document.getElementById(divView);

    if (boxNew.style.opacity === "1") {
        fadeOut(boxNew);
    } else {
        fadeIn(boxNew);
    }


    if (boxView.style.opacity === "1") {
        fadeOut(boxView);
    } else {
        fadeIn(boxView);
    }

    if(document.getElementById(btnNew).style.display == "block"){
        document.getElementById(btnNew).style.display = "none";
    }else{
        document.getElementById(btnNew).style.display = "block";
    }
}

function fadeIn(el) {
    el.style.display = "block";
    el.style.opacity = 0;

    requestAnimationFrame(() => {
        el.style.transition = "opacity 200ms ease";
        el.style.opacity = 1;
    });
}

function fadeOut(el) {
    el.style.transition = "opacity 200ms ease";
    el.style.opacity = 0;

    setTimeout(() => {
        el.style.display = "none";
    }, 200);
}
/*
function fadeIn(el) {
    el.style.opacity = 0;
    el.style.display = "block";

    let op = 0;
    const timer = setInterval(() => {
        op += 0.05;
        el.style.opacity = op;

        if (op >= 1) clearInterval(timer);
    }, 20);
}

function fadeOut(el) {
    let op = 1;
    const timer = setInterval(() => {
        op -= 0.05;
        el.style.opacity = op;

        if (op <= 0) {
            clearInterval(timer);
            el.style.display = "none";
        }
    }, 20);
}
*/