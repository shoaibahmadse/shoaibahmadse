const dishCont = document.querySelector("#dish-container");
const catBtn = document.querySelectorAll(".cat-btn");
const url = window.location.href;
const urlShort = url.substr(0, url.lastIndexOf("/"));
const fullUrl = urlShort + "/media/dish/";
const loader = document.querySelector(".loader");

function changeCat(catName) {
  catBtn.forEach((btn) => {
    if (btn.id == catName) {
      btn.style.background = "#faf089";
    } else {
      btn.style.background = "#ed8936";
    }
  });

  dishCont.innerHTML = ``;
  var xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    urlShort + "/ajax/get-dish.php?category-name=" + catName,
    true
  );

  xhr.onload = function () {
    if (this.status == 200) {
      loader.classList.add("hidden");
      var dishData = JSON.parse(this.responseText);
      for (i in dishData) {
        let dishId = dishData[i].id;
        let dishName = dishData[i].dish;
        let dishDisc = dishData[i].dish_detail;
        let dishImage = dishData[i].image;
        generateDish(i, dishName, dishDisc, dishImage, dishId);
      }
      if (catName != "all") {
        history.pushState("category-name", "page-title", "?name=" + catName);
      } else {
        history.pushState("View All", "page-title", "category.php");
      }
    }
  };
  loader.classList.remove("hidden");
  xhr.send();
}

function getAttributes(dishID, iterator) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", urlShort + "/ajax/get-dish.php?dish-id=" + dishID, true);

  xhr.onload = function () {
    if (this.status == 200) {
      var attributes = JSON.parse(this.responseText);
      for (j in attributes) {
        let attributeName = attributes[j].attribute;
        let attributePrice = attributes[j].price;
        setAttributes(attributeName, attributePrice, iterator);
      }
    }
  };
  xhr.send();
}

function setAttributes(name, price, jj) {
  //Set price through a seperate function and maybe from here call second fucntion on change
  const select = document.querySelector("#select-tag" + jj);
  let attributeSpace = `<option value="${name}" >${name}: €${price}</option>`;
  $(select).append(attributeSpace);
}

function generateDish(ii, name, disc, img, id) {
  let dishImgPath = fullUrl + img;
  let dishCard = `  
                        <article id="dish-card" class="deal-card m-3 bg-white shadow-lg hover:shadow-2xl rounded-t-lg">
                            <div class = "deal-img-container" >
                                <img id = "dish-image${ii}" class="inline w-full h-full deal-img rounded-t-lg" src="${dishImgPath}">
                            </div>
                            <div class="disc border-t-2 border-black">
                                <h2 id="dish-name${ii}" class="fancy-font text-md md:text-lg font-bold text-left p-2"></h2>
                                <p id="dish-disc${ii}" class="p-2 text-left text-sm"></p>
                            </div>
                            <div class="price-select m-1">
                                <select id = "select-tag${ii}" class = "w-full rounded-md bg-gray-400 text-lg p-1" >
                                </select>
                                <p class="price-box"></p>
                            </div>
                        </article>
                    `;
  $(dishCont).append(dishCard);
  let dishNameField = document.querySelector("#dish-name" + ii);
  let dishDiscField = document.querySelector("#dish-disc" + ii);

  dishNameField.innerHTML = `<h2 id="dish-name${ii}" class="text-sm">${name}</h2>`;
  dishDiscField.innerHTML = `<p id="dish-disc${ii}" class="p-2">${disc}</p>`;
  getAttributes(id, ii);
}
