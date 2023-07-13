import React, { useEffect, useState } from 'react';
import Select from 'react-select';

const MultiSelect = () => {
    const [hours, setHours] = useState([]);

    useEffect(() => {
        // Récupérer les données des heures depuis le backend et les mettre à jour dans le state
        const fetchHours = async () => {
            try {
                // Effectuer une requête HTTP vers le backend pour obtenir les données des heures
                const response = await fetch('/appointments/hours');
                const data = await response.json();
                // Mettre à jour le state avec les données des heures
                setHours(data);
            } catch (error) {
                console.error('Erreur lors de la récupération des heures', error);
            }
        };

        fetchHours();
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
        fetch('/some-api', { method: form.method, body: formData });
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
        <form method="post" onSubmit={handleSubmit}>
        <div className="select-wrapper">
            <label>
                <b>Veuillez sélectionner votre/vos créneau(x) dans la liste déroulante ci-dessous</b>
            </label>
            <Select options={options}
                    isMulti
                    name="hours"
                    className="basic-multi-select"
                    classNamePrefix="select"
                    closeMenuOnSelect={false}
                    placeholder='Selectionner'
                //    multiple={true}

                  //  onChange={e => {

                //      const options = option.map(options,index =>
                //          value.index);
                //      label(hours);
                //    }}




            />
        </div>
            {/*    <button type="reset"> - Supprimer ma selection</button> */}
            <button type="submit" className={"mt-3"}> + Ajouter ma selection au panier</button>
        </form>



        </>
    );
};

export default MultiSelect;
