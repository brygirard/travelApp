import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import{Provider} from "react-redux"
import store from "./components/red.js"

import Header from './components/Header/Header';
import ProfilePage from './components/ProfilePage/ProfilePage';
import RecPage from './components/RecPage/RecPage';
import BrowsePage from './components/BrowsePage/BrowsePage';
import LoginPage from './components/LoginPage/LoginPage';
import CreatePage from './components/CreatePage/CreatePage';


import {BrowserRouter as Router, Route} from 'react-router-dom'
import registerServiceWorker from './registerServiceWorker';






const App = () => {
    return(
    <Router>
        <div>
            <Header/>
            <Route exact path="/" component={ProfilePage}></Route>
            <Route path="/browse" component={BrowsePage}></Route>
            <Route path="/rec" component={RecPage}></Route>
            <Route path="/login" component={LoginPage}></Route>
            <Route path="/create" component={CreatePage}></Route>
        </div>
    </Router>
    )
}

ReactDOM.render(<Provider store = {store} ><App /></Provider>, document.getElementById('root'));
registerServiceWorker();
