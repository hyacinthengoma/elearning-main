// assets/app.js
import { registerVueControllerComponents } from '@symfony/ux-vue';

registerVueControllerComponents(require.context('./react/controllers', true, /\.vue$/));
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/styles.scss';

// start the Stimulus application
import './bootstrap';


