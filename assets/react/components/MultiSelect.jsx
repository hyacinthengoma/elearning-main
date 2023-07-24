import React, { useEffect, useState } from 'react';
import Select from 'react-select';

import Calendar from 'react-calendar';
import './App.css';
import 'react-calendar/dist/Calendar.css'
import Time from './Time.js'

const MultiSelect = () => {
    const [hours, setHours] = useState([]);

    const [date, setDate] = useState(new Date())
    const [showTime, setShowTime] = useState(false)



    useEffect(() => {
        // Récupérer les données des heures depuis le backend et les mettre à jour dans le state
        const fetchHours = async () => {
            try {
                // Effectuer une requête HTTP vers le backend pour obtenir les données des heures
                const response = await fetch('/appointments/hours');
                console.log(response);
                const data = await response.json();

                // Mettre à jour le state avec les données des heures
                setHours(data);
               // console.log(data);
            } catch (error) {
                console.error('Erreur lors de la récupération des heures', error);
            }
        };

        fetchHours();
       // console.log(fetchHours());
    }, []);

    const options = hours.map((hour, index) => ({
        value: index,
        label: hour,
    }));


// -----------------------------------------------------------

    function handleSubmit(e) {
        // Prevent the browser from reloading the page
        e.preventDefault();
        // Read the form data
        const form = e.target;
        const formData = new FormData(form);
        // You can pass formData as a fetch body directly:
        fetch('/cart', { method: form.method, body: formData });
        // You can generate a URL out of it, as the browser does by default:
        console.log(new URLSearchParams(formData).toString());
        // You can work with it as a plain object.
        const formJson = Object.fromEntries(formData.entries());
        console.log(formJson); // (!) This doesn't include multiple select values
        // Or you can get an array of name-value pairs.
        console.log([...formData.entries()]);
    }



//_______________________________________________________________________


    return (
        <>
            <div className='app'>
                <h1 style={{fontSize:"large"}} className='header'><u><i>Ajouter des créneaux à votre panier</i></u></h1>
                <div>
                    <p>
                        {/* affiche la date courante*/}
                       {date.toDateString()}
                    </p>
                    <Calendar onChange={setDate} value={date} onClickDay={() => setShowTime(true)}/>
                </div>

                {date.length > 0 ? (
                    <p>
                        <span>Start:</span>
                        {date[0].toDateString()}
                        &nbsp;
                        &nbsp;
                        <span>End:</span>{date[1].toDateString()}
                    </p>
                ) : (
                    <p>
                        <span>Date par défaut   :</span>{date.toDateString()}
                    </p>
                )
                }
                <Time showTime={showTime} date={date}/>

            </div>






        </>
    );
};

export default MultiSelect;
