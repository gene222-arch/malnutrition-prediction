require('./bootstrap');

import RFA from './../../node_modules/random-forest-classifier'
window.RandomForestClassifier = new RFA.RandomForestClassifier({ n_estimators: 10 });
