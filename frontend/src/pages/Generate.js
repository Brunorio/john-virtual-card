import React, { useState } from "react";
import axios from "axios";

export default function Generate() {
    const [loading, setLoading] = useState(false);
    const [ user, setUser ] = useState({
        name: "",
        linkedin: "",
        github: ""
    });

    const handleInputChange = (index, value) => {
        var _user = {...user};
        _user[index] = value;
        
        setUser(_user);
    }

    const downloadImage = (image, name) => {
        var a = document.createElement("a");
        a.href = image;
        a.download = name;
        a.click();
    }

    const handleButtonClick = () => {
        if(!user.name) return;

        setLoading(true);

        var bodyFormData = new FormData();
        bodyFormData.append("name", user.name);
        bodyFormData.append("linkedin", user.linkedin || "");
        bodyFormData.append("github", user.github || "");

        axios({
            method: "post",
            url: `${process.env.REACT_APP_API}generate`,
            data: bodyFormData,
            headers: { "Content-Type": "multipart/form-data" },
        })
        .then(function (response) {
            if(response?.data?.success){
               downloadImage(response.data.data.image, `${user.name.replace(" ", "-")}.png`);
            } else alert(response?.data?.message || "Cannot generate image");
        })
        .catch(function (response) {
            alert("Cannot generate image");
            console.log(response);
        }).finally(() => setLoading(false));

    }

    return (
       <div style={{ padding: '10px' }}>
            <h1>QR Code Image Generator</h1>
            <div >
                <div className="formGroup">
                    <div className="myLabel"><label>Name</label></div>
                    <div className="myInput"><input text="text" value={user.name} onChange={e => handleInputChange('name', e.target.value)} /></div>
                </div>
                <div className="formGroup">
                    <div className="myLabel"><label>Linkedin URL</label></div>
                    <div className="myInput"><input text="text" value={user.linkedin} onChange={e => handleInputChange('linkedin', e.target.value)} /></div>
                </div>
                <div className="formGroup">
                    <div className="myLabel"><label>Github URL</label></div>
                    <div className="myInput"><input text="text" value={user.github} onChange={e => handleInputChange('github', e.target.value)} /></div>
                </div>
                <button onClick={handleButtonClick} disabled={loading} type="button">{loading ? 'Loading...' : 'Generate Image'}</button>
            </div>
       </div>
    )
}