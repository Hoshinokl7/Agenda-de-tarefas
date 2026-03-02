const botao = document.getElementById("tema-btn");
const icone = document.getElementById("tema-icone");

botao.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        icone.textContent = "☀️"; 
        localStorage.setItem("tema", "dark");
    } else {
        icone.textContent = "🌙"; 
        localStorage.setItem("tema", "light");
    }
});


if (localStorage.getItem("tema") === "dark") {
    document.body.classList.add("dark");
    icone.textContent = "☀️";
} else {
    icone.textContent = "🌙";
}