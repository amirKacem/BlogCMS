import '../css/app.scss';

import {Dropdown} from "bootstrap";

document.addEventListener('DOMContentLoaded',function(){
    new App();
})

class App{
    constructor() {
        this.enableDropDown();
        this.handleCommentForm();
    }

    enableDropDown = () => {
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new Dropdown(dropdownToggleEl)
        })
    }

    handleCommentForm(){
        const commentForm = document.querySelector('form.commentForm');
        if(null=== commentForm){
            return;
        }

        document.addEventListener('submit',async function (e){
            e.preventDefault();
            const  response = await fetch('/ajax/comment',{
                method: 'POST',
                body: new FormData(e.target)
            })

            if(!response.ok){
                return;
            }
            const  json = await response.json();
            if(json.code === "CONTENT_ADDED_SUCCESSFULLY"){
                const commentList =  document.querySelector('.comment-list');
                const commentCard =  document.querySelector('.comment-count');
                const commentContent =  document.querySelector('#comment-content');
                commentList.insertAdjacentElement('beforeend',json.message);
                commentList.lastElementChild.scrollIntoView();
                commentCard.innerText = response.numberComments;
                commentContent.value = '';

            }
        });

    }
}
