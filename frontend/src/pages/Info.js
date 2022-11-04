import React, { useState, useEffect } from "react";
import { useParams } from 'react-router-dom';
import axios from "axios";


export default function Info() {
    const [loading, setLoading] = useState('Loading...');
    const [user, setUser] = useState({});
    const { uri } = useParams();

    useEffect(() => {
        var bodyFormData = new FormData();
        bodyFormData.append("uri", uri);

        axios({
            url: `${process.env.REACT_APP_API}info`,
            method: "POST",
            data: bodyFormData
        }).then(response => {
            if(response?.data?.success){
                setUser(response.data.data);
                setLoading(false);
            } else {
                setLoading(response?.data?.message || 'User not found');
            }
        }).catch(error => {
            setLoading('User not found');
        });
    }, []);

    if(loading) 
        return <h1 style={{ textAlign: 'center', marginTop: 50 }}>{loading}</h1>;

    return (
        <div style={{ padding: 20 }}>
            <p>Hello, my name is {user.name}</p>
            <h1>My History</h1>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an </p>
            <div style={{ display: 'flex', gap: 10 }}>
                {user.github ? <a rel="noreferrer" target="_blank" href={user.github}>Github</a> : <></>}
                {user.linkedin ? <a rel="noreferrer" target="_blank" href={user.linkedin}>Linkedin</a> : <></>}
            </div>
        </div>
    );
 
}