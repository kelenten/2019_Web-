//上传图片相关代码
let input = document.getElementById('upload');
let tips = document.getElementById('tips');
let reg = new RegExp(".+(.JPEG|bai.jpeg|.JPG|.jpg|.GIF|.gif|.BMP|.bmp|.PNG|.png)$","i");
if (typeof FileReader === 'undefined'){
    tips.innerHTML = "你的浏览器不支持";
    input.setAttribute('disabled','disabled');
}
input.onchange = function () {
    let reader = new FileReader();
    reader.readAsDataURL(input.files[0]);
    let str = document.getElementById('upload').value.toString().split('\\');
    if(str[str.length - 1].match(reg) != null){
        reader.onload = function () {
            tips.innerHTML = '<img src="' + reader.result + '" class="img">';
        };
        document.getElementById('url').innerText = str[str.length - 1];
    } else {
        alert('上传文件格式错误！');
    }
};

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
        console.log(selectedText);
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
上传/更改
 */
let title = document.getElementById('title');
let description = document.getElementById('description');
let contentSelect = document.getElementById('content');
let citySelect = document.getElementById('city');

function upload() {
    let contentText = contentSelect.options[contentSelect.selectedIndex].text;
    let countryText = countrySelect.options[countrySelect.selectedIndex].text;
    let cityText = citySelect.options[citySelect.selectedIndex].text;
    if(tips.innerText != '图片未上传'){
        if(title.value != ''){
            if(description.value != ''){
                if(contentText != 'Select by Content'){
                    if(countryText != 'Select by Country'){
                        if(cityText != 'Select by City'){
                            let userName = document.getElementById('userName').innerText;
                            let ID = document.getElementById('ImageID').innerText;
                            let titleText = title.value;
                            let descriptionText = description.value;
                            let PATH = document.getElementById('url').innerText;
                       //若有图片id则进行更改，否则是上传
                            if(ID == ''){
                                $.post(
                                        'uploadNew.php',
                                        {
                                            userName:userName,
                                            PATH:PATH,
                                            title:titleText,
                                            description:descriptionText,
                                            content:contentText,
                                            country:countryText,
                                            city:cityText
                                        },
                                        function(data,status) {
                                            alert('上传成功');
                                        });
                            } else {
                                    $.post(
                                        'modify.php',
                                        {
                                            ImageID:ID,
                                            userName:userName,
                                            PATH:PATH,
                                            title:titleText,
                                            description:descriptionText,
                                            content:contentText,
                                            country:countryText,
                                            city:cityText
                                        },
                                        function(data,status) {
                                            alert('修改成功');
                                        });
                            }
                            window.location.href = 'my_photo.php';
                        } else {
                            alert('请选择City!')
                        }
                    } else {
                        alert('请选择Country!')
                    }
                } else {
                    alert('请选择Content!');
                }
            } else {
                alert('请添加描述！');
            }
        } else {
            alert('请添加标题！');
        }
    } else {
        alert('请添加图片！');
    }


}