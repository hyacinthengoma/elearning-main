import React, { useState, useEffect } from 'react';

const AppointmentHours = () => {
    const [hours, setHours] = useState([]);

    useEffect(() => {
        // Récupère les heures de rendez-vous.
        const fetchHours = async () => {
            const response = await fetch('/appointments/hours');
            const data = await response.json();

            setHours(data.hours);
        };

        fetchHours();
    }, []);

    return (
        <div>
            <h1>Heures de rendez-vous</h1>
            <ul>
                {hours.map((hour) => (
                    <li key={hour.id}>{hour.start} - {hour.end}</li>
                ))}
            </ul>
        </div>
    );
};

export default AppointmentHours;