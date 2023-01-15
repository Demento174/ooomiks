import '../less/style.less';

document.addEventListener('DOMContentLoaded', function(){
    change_variation();
});


function change_variation()
{
    let buttons = document.querySelectorAll('.variations_form .options .inline-select a')
    buttons.forEach((button)=>
    {
        button.addEventListener('click',(event)=>
        {
            event.preventDefault();

            if(false === event.target.classList.contains('active')
                &&
                null !== document.querySelector(`[data-attribute-name="${event.target.getAttribute('data-attribute-name')}"].active`))
            {
                document
                    .querySelector(`[data-attribute-name="${event.target.getAttribute('data-attribute-name')}"].active`)
                    .classList
                    .remove('active');


            }

            event.target.classList.add('active');

            let targetSelect = document.querySelector(`#${event.target.getAttribute('data-attribute-name')}`);
            let key_option = null;

            targetSelect.querySelectorAll('option').forEach((_option,key)=>
            {

                if(button.getAttribute('data-value') === _option.value)
                    key_option = key;
            })
            if(null === key_option)
                throw 'Нужный вариант не найден';

            targetSelect.selectedIndex = key_option;


            let evt = new Event('change',{"bubbles":true, "cancelable":false,"cancleBubble":true})
            targetSelect.dispatchEvent(evt);

        })
    })
}