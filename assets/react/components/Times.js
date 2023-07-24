import React from 'react'
import {useState} from 'react';
import Calendar from 'react-calendar';
import './App.css';

const time = ['08:00','09:00','10:00','14:00','15:00']

// example for today's labels and invalids
const myLabels = React.useMemo(() => {
    return [{
        start: '2023-07-23',
        textColor: '#e1528f',
        title: '3 SPOTS'
    }];
}, []);

const myInvalid = React.useMemo(() => {
    return [{
        start: '2023-07-23T08:00',
        end: '2023-07-23T13:00'
    }, {
        start: '2023-07-23T15:00',
        end: '2023-07-23T17:00'
    }, {
        start: '2023-07-23T19:00',
        end: '2023-07-23T20:00'
    }];
}, []);


function Times(props) {

    const [event, setEvent] = useState(null)
    const [info, setInfo] = useState(false)

    function displayInfo(e) {
        setInfo(true);
        setEvent(e.target.innerText);
    }

    return (

        <div className="times">
            {time.map(times => {
                return (
                    <div>
                        <button onClick={(e)=> displayInfo(e)}> {times} </button>
                    </div>
                )
            })}
            <div>
                {info ? `Your appointment is set to ${event} ${props.date.toDateString()}` : null}
            </div>
        </div>
    )
}



export default Times;