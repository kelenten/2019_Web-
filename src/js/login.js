let form = document.getElementsByTagName("form")[0];
let userName = document.getElementsByTagName("input")[0];
let passWord = document.getElementsByTagName("input")[1];
let reEnter = document.getElementsByTagName("input")[2];

//用户名/邮箱合法性验证
userName.addEventListener('blur',checkUserName);
function checkUserName() {
    if(userName.value){
        if(document.getElementById("insert_p_5")){
            form.removeChild(document.getElementById("insert_p_5"));
        }
        let reg1 = new RegExp("^[0-9A-Za-z\-_\.]+@[a-zA-Z0-9\_-]+(\.[a-zA-Z0-9\_-]+)+$");
        let reg2 = new RegExp("^[a-zA-Z0-9_]+$");
        let boolean1 = false;
        if(userName.value.match(reg1) || userName.value.match(reg2)){
            boolean1 = true;
        }
        if(boolean1 == false){
            if(!form.contains(document.getElementById("insert_p_1"))){
                let p2 = document.getElementById("p2");
                let insert_p1 = document.createElement("p");
                insert_p1.innerHTML = "请输入正确格式的邮箱或是账号！账号只能包含大小写英文字母，数字以及下划线。"
                insert_p1.id = "insert_p_1";
                insert_p1.style.color = "#bd5e61";
                insert_p1.style.fontWeight = "blond";
                insert_p1.style.fontSize = "12px";
                form.insertBefore(insert_p1,p2);
            }
        } else {
            if(document.getElementById("insert_p_1")){
                form.removeChild(document.getElementById("insert_p_1"));
            }

        }
    }
}

//密码合法性验证
passWord.addEventListener('blur',checkPassword);
function checkPassword() {
    let p3 = document.getElementById("p3");
    if(passWord.value){
        if(document.getElementById("insert_p_6")){
            form.removeChild(document.getElementById("insert_p_6"));
        }
        let reg = new RegExp("^[0-9A-Za-z_]{6,}$");
        if (passWord.value.match(reg) == null) {
            if (!form.contains(document.getElementById("insert_p_2"))) {

                let insert_p2 = document.createElement("p");
                insert_p2.innerHTML = "密码格式错误，只能包含大小写英文字母，数字以及下划线，至少6位。"
                insert_p2.id = "insert_p_2";
                insert_p2.style.color = "#bd5e61";
                insert_p2.style.fontWeight = "blond";
                insert_p2.style.fontSize = "12px";
                form.insertBefore(insert_p2, p3);
            }
        } else {
            if (document.getElementById("insert_p_2")) {
                form.removeChild(document.getElementById("insert_p_2"));
            }
            if(document.getElementById("insert_p_3")){
                form.removeChild(document.getElementById("insert_p_3"));
            }
        }
    }
}
//检验第二次密码是否输入相同
reEnter.addEventListener('focus',checkPE);
function checkPE(){
    if(passWord.value == "" && document.getElementById("insert_p_3") == null){
        if(document.getElementById("insert_p_4")){
            form.removeChild(document.getElementById("insert_p_4"));
        }
        let p4 = document.getElementById("p4");
        let insert_p3 = document.createElement("p");
        insert_p3.innerHTML = "请先输入密码！";
        insert_p3.id = "insert_p_3";
        insert_p3.style.color = "#bd5e61";
        insert_p3.style.fontWeight = "blond";
        insert_p3.style.fontSize = "12px";
        form.insertBefore(insert_p3, p4);
    }
}

reEnter.addEventListener('blur',checkRE);
function checkRE(){
    if(passWord.value){
        if(reEnter.value != passWord.value){
            if(document.getElementById("insert_p_4") == null){let p4 = document.getElementById("p4");
                let insert_p4 = document.createElement("p");
                insert_p4.innerHTML = "与上次输入不同！";
                insert_p4.id = "insert_p_4";
                insert_p4.style.color = "#bd5e61";
                insert_p4.style.fontWeight = "blond";
                insert_p4.style.fontSize = "12px";
                form.insertBefore(insert_p4, p4);}
        } else {
            form.removeChild(document.getElementById("insert_p_4"));
        }

    } else if(reEnter.value == "" && document.getElementById("insert_p_3")){
        form.removeChild(document.getElementById("insert_p_3"));
    }
    if(reEnter.value != "" && document.getElementById("insert_p_7")){
        form.removeChild(document.getElementById("insert_p_7"));
    }
}

//表单合法性验证，预提交时触发
function checkAll() {
    let boolean = true;
    if(userName.value == ""){
        if(document.getElementById("insert_p_5") == null){
            let p2 = document.getElementById("p2");
            let insert_p5 = document.createElement("p");
            insert_p5.innerHTML = "请输入账号或邮箱！";
            insert_p5.id = "insert_p_5";
            insert_p5.style.color = "#bd5e61";
            insert_p5.style.fontWeight = "blond";
            insert_p5.style.fontSize = "12px";
            form.insertBefore(insert_p5,p2);
        }
        boolean = false;
    }
    if(passWord.value == ""){
        if(document.getElementById("insert_p_6") == null){
            let p3 = document.getElementById("p3");
            let insert_p6 = document.createElement("p");
            insert_p6.innerHTML = "请输入密码！";
            insert_p6.id = "insert_p_6";
            insert_p6.style.color = "#bd5e61";
            insert_p6.style.fontWeight = "blond";
            insert_p6.style.fontSize = "12px";
            form.insertBefore(insert_p6,p3);
        }
        boolean = false;
    }
    if(passWord.value != "" && userName.value != "" && reEnter.value == ""){
        if(document.getElementById("insert_p_4")){
            form.removeChild(document.getElementById("insert_p_4"));
        }
        if(document.getElementById("insert_p_7") == null){
            let p4 = document.getElementById("p4");
            let insert_p7 = document.createElement("p");
            insert_p7.innerHTML = "请再次输入密码！";
            insert_p7.id = "insert_p_7";
            insert_p7.style.color = "#bd5e61";
            insert_p7.style.fontWeight = "blond";
            insert_p7.style.fontSize = "12px";
            form.insertBefore(insert_p7,p4);
        }
        boolean = false;
    } else if(reEnter.value != passWord.value){
        if(document.getElementById("insert_p_7")){
            form.removeChild(document.getElementById("insert_p_7"));
        }
        if(document.getElementById("insert_p_4") == null){
            let p5 = document.getElementById("p5");
            let insert_4 = document.createElement("p");
            insert_4.innerHTML = "与上次输入不同！";
            insert_4.id = "insert_p_4";
            insert_4.style.color = "#bd5e61";
            insert_4.style.fontWeight = "blond";
            insert_4.style.fontSize = "12px";
            form.insertBefore(insert_4,p5);
        }

        boolean = false;
    }
    return boolean;
}