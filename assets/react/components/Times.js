import React, { useState, useEffect } from "react";
import Calendar from "react-calendar";

const Times = ({ date }) => {
    const [event, setEvent] = useState(null);
    const [info, setInfo] = useState(false);
    const [time, setTime] = useState([]);

    useEffect(() => {
        fetchTime();
    }, []);

    function displayInfo(e) {
        setInfo(true);
        setEvent(e.target.innerText);
    }

    async function fetchTime() {
        const response = await fetch("/appointments/hours");
        const data = await response.json();
        setTime(data);
    }

    return (
        <div className="times">
            {time.map(times => (
                <div key={times}>
                    <button onClick={(e) => {
                        if (times === date) {
                            setInfo(true);
                            setEvent(times);
                        } else {
                            setInfo(false);
                            setEvent(null);
                        }
                    }}>{times}</button>
                </div>
            ))}
            <div>
                {info ? `Your appointment is set to ${event} ${date.toDateString()}` : null}
            </div>
        </div>
    );
};

export default Times;