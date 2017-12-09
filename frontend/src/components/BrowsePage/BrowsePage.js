import React, { Component } from 'react';
import {Container, Image, Button, Header, Input, Card, List, Icon, Grid} from 'semantic-ui-react'
import src from './default.jpg';
import './BrowsePage.css';
import  axios from 'axios';





class BrowsePage extends Component {

    state = {
      searchTerm: '',
      image: src,
      city: '',
      area: '',
      country: '',
      timezone: ''
    }

getImage(place){

	 let search = "https://pixabay.com/api/?key=7317382-d404012ffb7b71a4fff800cc5&per_page=3&safesearch=true&image_type=photo&q=".concat(this.state.city);
	console.log(search);
	axios.get(search)
   .then(function (response) {
      console.log(response);
      this.setState({image: response.data.hits[0].previewURL});
    })
  .catch(function (error) {
    console.log(error);
  });

}

handleSearchChange(e) {
   this.setState({searchTerm: e.target.value});

}


searchPlaces(e){
  console.log("Searching....");

  var self = this;
  var params = new URLSearchParams();
  params.append('searchTerm', this.state.searchTerm);

  axios.post("backend/searchTree.php", params, {
       headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    }
  )
  .then(function (response) {
    console.log(response);
     self.setState({
    	city: response.data[0][4],
    	area: response.data[0].Admin1_nameascii,
    	country: response.data[0].official_name_en,
    	population: response.data[0].population,
    	timezone:response.data[0].timezone
    });
  
   })
  .catch(function (error) {
    console.log(error);
  });

 

}


  render() {
    return (
 <Container>
 <div className="App">
   <div className="searchBar">
      <Input className="seachField" placeholder = "Enter City name..." onChange = {this.handleSearchChange.bind(this)}/>
      <Button onClick = {this.searchPlaces.bind(this)}> Search </Button>
   </div>
   <div className="myCard">
    <Grid relaxed>
       <Card>
          <Image src= {this.state.image} />
          <Card.Content>
      <Card.Header>
        {this.state.city}
      </Card.Header>
      <Card.Meta>
        <span className='date'>
          Details About the City
        </span>
      </Card.Meta>
      <Card.Description>

         <List>
           <List.Item>City: {this.state.city}</List.Item>
           <List.Item>Area: {this.state.area}</List.Item>
           <List.Item>Country: {this.state.country}</List.Item>
           <List.Item>Timezone: {this.state.timezone}</List.Item>
         </List>


      </Card.Description>
    </Card.Content>
    <Card.Content extra>
      <a>
        <Icon name='user' />
        {this.state.population} People
      </a>
    </Card.Content>
  </Card>
  </Grid>
</div>
   </div>
  </Container>

    );
  }

}

export default BrowsePage;