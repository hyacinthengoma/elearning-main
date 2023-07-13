/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
//import React from "react";
//import * as ReactDOM from "react-dom"
//ReactDOM.render(
//<div>

 //   <h1>hello</h1>,
  //  <h2>hello2</h2>,

   // document.getElementById("app")
//</div>,

// any CSS you import will output into a single css file (app.scss in this case)
import '/assets/styles/styles.scss';


// start the Stimulus application
import '/assets/bootstrap';
import React from "react";
import App from "./components/app";
import {createRoot} from "react-dom/client";
import Select from "react-select";
import MyComponent from "./components/MultiSelect";
import MultiSelect from "./components/MultiSelect";


//import { colourOptions } from '../data';

const container = document.getElementById("app");
const root = createRoot(container);
root.render(
    <React.StrictMode>

        <App />
        <MultiSelect />

    </React.StrictMode>
);


