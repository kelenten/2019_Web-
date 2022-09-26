let form = document.getElementsByTagName("form")[0];
let userName = document.getElementsByTagName("input")[0];
let Email = document.getElementsByTagName("input")[1];
let passWord = document.getElementsByTagName("input")[2];
let reEnter = document.getElementsByTagName("input")[3];

//用户名合法性验证
userName.addEventListener('blur',checkUserName);
function checkUserName() {
    if(userName.value){
        if(document.getElementById("insert_p_5")){
            form.removeChild(document.getElementById("insert_p_5"));
        }
        if(document.getElementById("insert_p_10")){
            form.removeChild(document.getElementById("insert_p_10"));
        }
        let reg1 = new RegExp("^[a-zA-Z0-9_]+$");
        if(userName.value.match(reg1) == null){
            if(!form.contains(document.getElementById("insert_p_1"))){
                let p2 = document.getElementById("p2");
                let insert_p1 = document.createElement("p");
                insert_p1.innerHTML = "账号只能包含大小写英文字母，数字以及下划线!"
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

//邮箱合法性验证
Email.addEventListener('blur',checkEmail);
function checkEmail(){
    if(Email.value){
        if(document.getElementById("insert_p_6")){
            form.removeChild(document.getElementById("insert_p_6"));
        }
        if(document.getElementById("insert_p_11")){
            form.removeChild(document.getElementById("insert_p_11"));
        }
        let reg1 = new RegExp("^[0-9A-Za-z\-_\.]+@[a-zA-Z0-9\_-]+(\.[a-zA-Z0-9\_-]+)+$");
        if(Email.value.match(reg1) == null){
            if(!form.contains(document.getElementById("insert_p_8"))){
                let p3 = document.getElementById("p3");
                let insert_p8 = document.createElement("p");
                insert_p8.innerHTML = "格式错误！";
                insert_p8.id = "insert_p_8";
                insert_p8.style.color = "#bd5e61";
                insert_p8.style.fontWeight = "blond";
                insert_p8.style.fontSize = "12px";
                form.insertBefore(insert_p8,p3);
            }
        } else {
            if(document.getElementById("insert_p_8")){
                form.removeChild(document.getElementById("insert_p_8"));
            }


        }
    }
}
//密码合法性验证
passWord.addEventListener('blur',checkPassword);
function checkPassword() {
    let p4 = document.getElementById("p4");
    if(passWord.value){
        if(document.getElementById("insert_p_9")){
            form.removeChild(document.getElementById("insert_p_9"));
        }
        let reg = new RegExp("^[0-9A-Za-z_]{6,}$");
        if (passWord.value.match(reg) == null) {
            if(document.getElementById("insert_p_13")){
                form.removeChild(document.getElementById("insert_p_13"));
            }
            if (!form.contains(document.getElementById("insert_p_2"))) {

                let insert_p2 = document.createElement("p");
                insert_p2.innerHTML = "密码格式错误，只能包含大小写英文字母，数字以及下划线，至少6位。"
                insert_p2.id = "insert_p_2";
                insert_p2.style.color = "#bd5e61";
                insert_p2.style.fontWeight = "blond";
                insert_p2.style.fontSize = "12px";
                form.insertBefore(insert_p2, p4);
            }
        } else {
            let wreg1 = new RegExp("^[0-9]{6,10}$");
            let wreg2 = new RegExp("^[A-Za-z]{6,10}$");
            if(passWord.value.match(wreg1) != null || passWord.value.match(wreg2) != null){
                if(document.getElementById("insert_p_13") == null){
                    let insert_p13 = document.createElement("p");
                    insert_p13.innerHTML = "密码太弱，请修改！";
                    insert_p13.id = "insert_p_13";
                    insert_p13.style.color = "#bd5e61";
                    insert_p13.style.fontWeight = "blond";
                    insert_p13.style.fontSize = "12px";
                    form.insertBefore(insert_p13, p4);
                }
            } else if(document.getElementById("insert_p_13")){
                form.removeChild(document.getElementById("insert_p_13"));
            }
            if (document.getElementById("insert_p_2")) {
                form.removeChild(document.getElementById("insert_p_2"));
            }
            if(document.getElementById("insert_p_3")){
                form.removeChild(document.getElementById("insert_p_3"));
            }
        }
    }

}
//检查密码是否相同
reEnter.addEventListener('focus',checkPE);
function checkPE(){
    if(passWord.value == "" && document.getElementById("insert_p_3") == null){
        if(document.getElementById("insert_p_4")){
            form.removeChild(document.getElementById("insert_p_4"));
        }
        let p5 = document.getElementById("p5");
        let insert_p3 = document.createElement("p");
        insert_p3.innerHTML = "请先输入密码！";
        insert_p3.id = "insert_p_3";
        insert_p3.style.color = "#bd5e61";
        insert_p3.style.fontWeight = "blond";
        insert_p3.style.fontSize = "12px";
        form.insertBefore(insert_p3, p5);
    }
}

reEnter.addEventListener('blur',checkRE);
function checkRE(){
    if(passWord.value){
        if(reEnter.value != passWord.value){
            if(document.getElementById("insert_p_4") == null){
                let p5 = document.getElementById("p5");
                let insert_p4 = document.createElement("p");
                insert_p4.innerHTML = "与上次输入不同！";
                insert_p4.id = "insert_p_4";
                insert_p4.style.color = "#bd5e61";
                insert_p4.style.fontWeight = "blond";
                insert_p4.style.fontSize = "12px";
                form.insertBefore(insert_p4, p5);}
        } else {
            if(document.getElementById("insert_p_4")){
                form.removeChild(document.getElementById("insert_p_4"));
            }
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
        if(document.getElementById("insert_p_10")){
            form.removeChild(document.getElementById("insert_p_10"));
        }
        if(document.getElementById("insert_p_5") == null){
            let p2 = document.getElementById("p2");
            let insert_p5 = document.createElement("p");
            insert_p5.innerHTML = "请输入账号！";
            insert_p5.id = "insert_p_5";
            insert_p5.style.color = "#bd5e61";
            insert_p5.style.fontWeight = "blond";
            insert_p5.style.fontSize = "12px";
            form.insertBefore(insert_p5,p2);
        }
        boolean = false;
    }
    if(Email.value == ""){
        if(document.getElementById("insert_p_11")){
            form.removeChild(document.getElementById("insert_p_11"));
        }
        if(document.getElementById("insert_p_6") == null){
            let p3 = document.getElementById("p3");
            let insert_p6 = document.createElement("p");
            insert_p6.innerHTML = "请输入邮箱！";
            insert_p6.id = "insert_p_6";
            insert_p6.style.color = "#bd5e61";
            insert_p6.style.fontWeight = "blond";
            insert_p6.style.fontSize = "12px";
            form.insertBefore(insert_p6,p3);
        }
        boolean = false;
    }
    if(passWord.value == ""){
        if(document.getElementById("insert_p_9") == null){
            let p4 = document.getElementById("p4");
            let insert_p9 = document.createElement("p");
            insert_p9.innerHTML = "请输入密码！";
            insert_p9.id = "insert_p_9";
            insert_p9.style.color = "#bd5e61";
            insert_p9.style.fontWeight = "blond";
            insert_p9.style.fontSize = "12px";
            form.insertBefore(insert_p9,p4);
        }
        boolean = false;
    }
    if(passWord.value != "" && userName.value != "" && Email.value != "" && reEnter.value == ""){
        if(document.getElementById("insert_p_4")){
            form.removeChild(document.getElementById("insert_p_4"));
        }
        if(document.getElementById("insert_p_7") == null){
            let p5 = document.getElementById("p5");
            let insert_p7 = document.createElement("p");
            insert_p7.innerHTML = "请再次输入密码！";
            insert_p7.id = "insert_p_7";
            insert_p7.style.color = "#bd5e61";
            insert_p7.style.fontWeight = "blond";
            insert_p7.style.fontSize = "12px";
            form.insertBefore(insert_p7,p5);
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
//检查用户名是否重复
function ExistUser() {
    let p2 = document.getElementById("p2");
    let insert_p10 = document.createElement("p");
    insert_p10.innerHTML = "该用户名已存在！";
    insert_p10.id = "insert_p_10";
    insert_p10.style.color = "#bd5e61";
    insert_p10.style.fontWeight = "blond";
    insert_p10.style.fontSize = "12px";
    form.insertBefore(insert_p10,p2);
}
//检查邮箱是否重复
function ExistEmail() {
    let p3 = document.getElementById("p3");
    let insert_p11 = document.createElement("p");
    insert_p11.innerHTML = "该邮箱已存在！";
    insert_p11.id = "insert_p_11";
    insert_p11.style.color = "#bd5e61";
    insert_p11.style.fontWeight = "blond";
    insert_p11.style.fontSize = "12px";
    form.insertBefore(insert_p11,p3);
}
