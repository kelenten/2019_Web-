/*
普通搜索
 */
let searchbt = document.getElementById('search');
searchbt.addEventListener('click',search);
function search(){
 let title = document.getElementById('title');
 //前往特定url保证图片输出
 window.location.href = 'Browser.php?title=' + title.value;
}


/*
二级联动
*/

let countrySelect = document.getElementById("country");
let selectedText;
let cities;
function postCountry(){
 selectedText = countrySelect.options[countrySelect.selectedIndex].text;
}
$(document).ready(function(){
 $("#country").click(function(){
  $.post("BrowserLinkage.php",{
       num:selectedText
      },
      function(data,status){
       if(data != '0'){
        cities = eval(data);
        let citySelect = document.getElementById("city");
        citySelect.innerHTML = "";
        let option = document.createElement("option");
        option.innerText = 'Select by City';
        option.hidden = true;
        option.selected = true;
        option.disabled = true;
        citySelect.appendChild(option);
        for (let i = 0; i < cities.length; i++) {
         let city = document.createElement('option');
         city.innerText = cities[i];
         citySelect.appendChild(city);
        }
       }
      });
 });
});
/*
三级筛选
 */
let contentSelect = document.getElementById('content');
let citySelect = document.getElementById('city');
let ISO;
let cityCode;

function filter() {
 if(contentSelect.selectedIndex != 0){
  if(countrySelect.selectedIndex != 0){
   if(citySelect.selectedIndex != 0){
    let contentText = contentSelect.options[contentSelect.selectedIndex].text;
    let countryText = countrySelect.options[countrySelect.selectedIndex].text;
    let cityText = citySelect.options[citySelect.selectedIndex].text;
    $(document).ready(function() {
     $.post(
         //在BrowserFilter.php中将国家名和城市名转换为ISO,CityCode
         'BrowserFilter.php',
     {
      country:countryText,
      city:cityText
     },
     function(data,status) {
          let result = eval(data);
          ISO = result[0];
          cityCode = result[1];
          //前往特定URL
      window.location.href = 'Browser.php?c1=' + contentText + '&c2=' + ISO + '&c3=' + cityCode;
     });
     });

   } else {
    alert('请选择City!')
   }
  } else {
   alert('请选择Country!')
  }
 } else {
  alert('请选择Content!');
 }
}