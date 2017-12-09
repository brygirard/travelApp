import React, { Component } from 'react';
import { Search, Card, Dropdown, Container, Modal, Image, Button, Header} from 'semantic-ui-react'
import src from './default.jpg';
import './BrowsePage.css';
import  axios from 'axios';





class BrowsePage extends Component {

    state = {
      searchTerm: ''
    }

getImage(place){

	let search = "https://pixabay.com/api/?key=7317382-d404012ffb7b71a4fff800cc5&per_page=3&safesearch=true&image_type=photo&q=".concat(place);
	console.log(search);
	axios.get(search)
   .then(function (response) {
      console.log(response);
      return response.data.hits[0].previewURL;
    })
  .catch(function (error) {
    console.log(error);
  });

}


searchPlaces(){



}


  render() {
    return (
 <Container>
 <div className="App">
   <div className="searchBar">
      <Search className="seachField" onClick = {this.searchPlaces()}/>
   </div>
      <p>Where the details over searched city will go </p>
   </div>
</Container>

    );
  }

}

export default BrowsePage;