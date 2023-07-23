import {useState} from 'react';
import Calendar from 'react-calendar';
import './App.css';
import Times from './Times.js'

import React from 'react'

function Time(props) {

    return (
        <div>
            {/* True affiche les horaires du calendrier dès le chargement de la page sans avoir à cliquer sur une date*/}
            {/* False ou ne rien mettre masque les horaires du calendrier à l'arrivée sur la page et il faut  cliquer sur une date pour voir ces horaires*/}

            {props.showTime ? <Times date={props.date} /> : null}
        </div>
    )
}

export default Time;