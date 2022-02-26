const mals = 
[
    {
        bmi: 18.5,
        feeling_tired_all_the_time: 1,
        poor_concentration: 1,
        short_for_their_age: 1,
        unintentional_weight_loss: 1,
        label: 'Malnourished'
    },
    {
        bmi: 18.5,
        feeling_tired_all_the_time: 0,
        poor_concentration: 1,
        short_for_their_age: 1,
        unintentional_weight_loss: 1,
        label: 'Malnourished'
    },
    {
        bmi: 18.5,
        feeling_tired_all_the_time: 1,
        poor_concentration: 0,
        short_for_their_age: 1,
        unintentional_weight_loss: 1,
        label: 'Malnourished'
    },
    {
        bmi: 18.5,
        feeling_tired_all_the_time: 1,
        poor_concentration: 1,
        short_for_their_age: 0,
        unintentional_weight_loss: 1,
        label: 'Malnourished'
    },
    {
        bmi: 20,
        feeling_tired_all_the_time: 1,
        poor_concentration: 1,
        short_for_their_age: 1,
        unintentional_weight_loss: 0,
        label: 'Malnourished'
    },
    {
        bmi: 20,
        feeling_tired_all_the_time: 0,
        poor_concentration: 0,
        short_for_their_age: 1,
        unintentional_weight_loss: 1,
        label: 'Moderately Malnourished'
    },
    {
        bmi: 20,
        feeling_tired_all_the_time: 1,
        poor_concentration: 0,
        short_for_their_age: 0,
        unintentional_weight_loss: 1,
        label: 'Moderately Malnourished'
    },
    {
        bmi: 20,
        feeling_tired_all_the_time: 1,
        poor_concentration: 1,
        short_for_their_age: 0,
        unintentional_weight_loss: 0,
        label: 'Moderately Malnourished'
    },
    {
        bmi: 22.5,
        feeling_tired_all_the_time: 0,
        poor_concentration: 0,
        short_for_their_age: 0,
        unintentional_weight_loss: 0,
        label: 'Healthy'
    }
];

const user = [
    {
        feeling_tired_all_the_time: 0,
        poor_concentration: 0,
        short_for_their_age: 1,
        unintentional_weight_loss: 0,
    }
];

const RandomForestClassifier = window.RandomForestClassifier;

RandomForestClassifier.fit(mals, null, "label", (err, trees) => 
{
    const pred = RandomForestClassifier.predict(user, trees);
    console.log(pred);
});

export default mals;