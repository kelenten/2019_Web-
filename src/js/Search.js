let titleRadio = document.getElementById('titleRadio');
let titleText = document.getElementById('title');
let descriptionRadio = document.getElementById('descriptionRadio');
let descriptionText = document.getElementById('description');
let filter = document.getElementById('filter');

filter.addEventListener('click',Search);
//通过url保持状态
function Search() {
    //根据按钮的选择进行标题或是描述的搜索
    if(titleRadio.checked){

        if(titleText.value != ''){
            window.location.href = 'Search.php?Title=' + titleText.value;
        } else {
            alert('请输入标题!');
        }
    } else if(descriptionRadio.checked){
        if(descriptionText.value != ''){
            window.location.href = 'Search.php?Description=' + descriptionText.value;
        } else {
            alert('请输入描述！')
        }
    }
}

