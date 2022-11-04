import React from 'react';
import { Route, Routes, BrowserRouter } from 'react-router-dom';

import Generate from './pages/Generate';
import Info from './pages/Info';

const App = () => {
    return(
        <BrowserRouter>
            <Routes>
                <Route path="/" exact element={ <Generate />} />
                <Route path="/:uri" exact element={<Info />} />
                <Route path="*" element={() => <h1>404 - Not Found</h1>} />
            </Routes>
        </BrowserRouter>
    );
}

export default App;
