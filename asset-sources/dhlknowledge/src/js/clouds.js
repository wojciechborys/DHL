import { gsap, TimelineMax } from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);
gsap.core.globals("ScrollTrigger", ScrollTrigger);

document.addEventListener("DOMContentLoaded", function (event) {
  // wait until images, links, fonts, stylesheets, and js is loaded
  window.addEventListener(
    "load",
    function (e) {
      let tl = gsap.timeline({
        scrollTrigger: {
          // markers: "true",
          trigger: ".clouds",
          start: "215px 60%",
          end: "+=700px",
          scrub: 1,
        },
      });

      tl.to(
        ".clouds__cloud-1",
        { duration: 5, scale: 1.3, opacity: 0.2 },
        "-=5"
      )
        .to(".clouds__cloud-2", { duration: 5, scale: 1.2 }, "-=5")
        // .to(
        //   ".clouds",
        //   { duration: 5, backgroundSize: "102%"},
        //   "-=5"
        // )
        .to(".clouds__text", { duration: 5, scale: 0.5 }, "-=5")
        .to(".clouds__cloud-3", { duration: 5, scale: 1.1 }, "-=5")
        .to(
          ".clouds__cloud-4",
          { duration: 5, scale: 1.7, opacity: 0.1 },
          "-=5"
        )
        .to(
          ".clouds__cloud-5",
          { duration: 5, scale: 1.5, opacity: 0.3 },
          "-=5"
        )
        .to(
          ".clouds__cloud-6",
          { duration: 5, scale: 1.7, opacity: 0.5 },
          "-=5"
        );
    },
    false
  );
});
