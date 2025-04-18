function searchProduct() {
    const input = document.getElementById("search").value.toLowerCase();
    const products = document.querySelectorAll(".product");
    let found = false;

    products.forEach((product) => {
      const name = product.querySelector(".product-name").innerText.toLowerCase();
      if (name.includes(input)) {
        product.style.display = "block";
        found = true;
      } else {
        product.style.display = "none";
      }
    });
  
    document.getElementById("not-found").style.display = found ? "none" : "block";
  }
  
