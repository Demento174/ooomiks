import '../less/style.less';

document.addEventListener('DOMContentLoaded',
    function()
    {
        change_variation();
    });


function change_variation()
{
    let buttons = document.querySelectorAll('.variations_form .options .inline-select a')
    buttons.forEach((button)=>
    {
        if(button.classList.contains('active'))
        {
            let targetSelect = document.querySelector(`#${button.getAttribute('data-attribute-name')}`);

            change_select(targetSelect,button.getAttribute('data-value'))
        }


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

            change_select(targetSelect,button.getAttribute('data-value'))

            let variation_id_input = document.querySelector('[name="variation_id"]');

            if(!variation_id_input || !variation_id_input.value)
                return false;
            change_image(variation_id_input.value);
            change_content(variation_id_input.value);
            change_attribution(variation_id_input.value);
        })
    })
}

function change_select(targetSelect,value)
{
    let key_option = null;

    targetSelect.querySelectorAll('option').forEach((_option,key)=>
    {

        if(value === _option.value)
            key_option = key;
    })


    if(null === key_option)
        throw 'Нужный вариант не найден';

    targetSelect.selectedIndex = key_option;


    let evt = new Event('change',{"bubbles":true, "cancelable":false,"cancleBubble":true})
    targetSelect.dispatchEvent(evt);

}

function change_image(variation_id)
{
    let new_image = document.querySelector(`[variation-id="${variation_id}"]`)

    if(!new_image)
        return false;
    let link = new_image.getAttribute('data-src');
    document.querySelectorAll('.woocommerce-product-gallery__wrapper').forEach(gallery=>gallery.style.display='none');
    document.querySelector(`.woocommerce-product-gallery__wrapper[variation-id="${variation_id}"]`).style.display = 'block';

}

function change_content(variation_id)
{
    let main_content =document.querySelector('.woocommerce-Tabs-panel .main_content');
    let variation_content = document.querySelector(`.variation_content[data-id="${variation_id}"]`);
    document.querySelectorAll(`.variation_content`).forEach(item=>item.style.display='none')
    if(variation_content)
    {

        main_content.style.display = 'none';

        variation_content.style.display = 'block';
    }else
        {
            main_content.style.display = 'block';
        }
}

function change_attribution(variation_id)
{

    let main_content =document.querySelector('.main_additional-information');
    let variation_content = document.querySelector(`.variation_additional-information[data-id="${variation_id}"]`);
    document.querySelectorAll(`.variation_additional-information`).forEach(item=>item.style.display='none')
    if(variation_content)
    {

        main_content.style.display = 'none';

        variation_content.style.display = 'block';
    }else
    {
        main_content.style.display = 'block';
    }
}