import fruits from "./../services/fruits.js";  
import vegetables from "./../services/vegetables.js";  
import meat from "./../services/meat.js";  
import fish from "./../services/fish.js";
import queryParam from './../utils/queryParam.js';

const RandomForestClassifier = window.RandomForestClassifier;

const categories = {
    fruits,
    vegetables,
    meat,
    fish
};

const handleSubmitBtn = () => 
{
    const category = queryParam.get('category').toLowerCase();
    const nutrient = $('#select-nutrient option:selected').val();
    const percentage = $('.input-percentage').val();

    const selectedCategory = categories[category];
    const characteristics = [nutrient];

    const rawData = [
        {
            [nutrient]: (parseFloat(percentage) / 100)
        }
    ];

    console.table(selectedCategory)

    const callback = async (err, trees) => {
        const recommendation = RandomForestClassifier.predict(rawData, trees)[0];

        const food = selectedCategory.find(({ name }) => name === recommendation);
        
        const html = `
            <h4 class="lead">Recommendation</h4>
            <div class="card">
                <img 
                    src="${ food.image_path }" 
                    class="card-img-top img-responsive mt-2"
                    width="100"
                    height="150"
                >
                <div class="card-body">
                    <div class="card-title mt-2"><strong>${ food.name }</strong></div>
                </div>
            </div>
        `;

        $('.recommendation').html(html);
    };

    RandomForestClassifier.fit(selectedCategory, characteristics, "name", callback);
};

$('.btn-submit').on('click', handleSubmitBtn);