const animateNav = () => {
    let menuButton = document.querySelector(".menu.menu--close2");
    let menuContainer = document.querySelector("nav");
    let menuItems = menuContainer.querySelectorAll("li");

    const hideNav = () => {
        let tl = gsap.timeline();
        tl.to(menuContainer, 0.5, {
                clipPath: "circle(0% at 100% 0)"
            })
            .to(menuContainer, 0.5, {
                display: "none"
            })
            .add(() => {
                menuButton.classList.remove("open");
                menuItems.forEach(item => {
                    item.style.opacity = 0;
                }, .8)
            })
    };

    menuButton.addEventListener("click", () => {
        if (menuButton.classList.contains("open")) {
            menuButton.classList.remove("open");
            hideNav();
        } else {
            menuButton.classList.add("open");
            let tl = gsap.timeline();
            tl.to(menuContainer, 0.1, {
                    display: "flex"
                })
                .to(menuContainer, .7, {
                    clipPath: "circle(150% at 100% 0)"
                })
                .add(() => {
                    menuButton.classList.add("open");
                    menuItems.forEach(item => {
                        tl.fromTo(item, .5, {
                            opacity: 0,
                            x: 25
                        }, {
                            opacity: 1,
                            x: 0
                        }, "-=.2")
                    })
                })
        }

        menuItems.forEach(element => {
            element.querySelector("a").addEventListener("click", (e) => {
                if(element.querySelector("a[href^='#']"))  e.preventDefault();
              
                let active = document.querySelector(".nav__item.active")
                active.classList.remove("active");
                element.classList.add("active");
                if(element.querySelector("a[href^='#']"))
                {
                    gsap.to(window, {
                        duration: .5,
                        scrollTo: {
                            y: element.querySelector("a").getAttribute("href"),
                            offsetY: 70
                        }
                    });
                }
                
                hideNav();
            })
        });


    });

    

    let sections = document.querySelectorAll("section[id]");
    sections.forEach(section => {
        let setActive = () => {
            let active = document.querySelector(".nav__item.active")
            active.classList.remove("active");
            navItem.parentNode.classList.add("active")
        }
        let navItem = document.querySelector(`li.nav__item > a[href='#${section.getAttribute('id')}'`);
        ScrollTrigger.create({
            trigger: "#" + section.getAttribute("id"),
            once: false,
            start: "top 50%",
            end: "bottom 50%",
            onEnter: setActive,
            onEnterBack: setActive,
            onLeaveBack: setActive,
            onLeave: setActive,
           
        });
    })


}
animateNav();