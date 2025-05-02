document.addEventListener("DOMContentLoaded", () => {
    // HEADER einfügen
    fetch("../components/header.html")
      .then(res => res.text())
      .then(html => {
        const wrapper = document.createElement("div");
        wrapper.innerHTML = html;
        document.body.insertBefore(wrapper, document.body.firstChild);
      });
  
    // FOOTER einfügen
    fetch("../components/footer.html")
      .then(res => res.text())
      .then(html => {
        const wrapper = document.createElement("div");
        wrapper.innerHTML = html;
        document.body.appendChild(wrapper);
      });
  });
  