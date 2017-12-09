import React, { Component } from 'react';
import { Button, Checkbox, Form, Grid} from 'semantic-ui-react'
import './CreatePage.css';
import axios from 'axios';


class CreatePage extends Component {


 state = { 
  firstName: '',
  lastName: '',
  emailAdress:'',
  password:'',
  airport: '',
  city: '',
  country:''
 }



 makeUser(e){
 	console.log("Creating User...")
  
   var params = new URLSearchParams();
   params.append('firstName', this.state.firstName);
   params.append('lastName', this.state.lastName);
   params.append('emailAddress', this.state.emailAdress);
   params.append('passWord', this.state.password);
   params.append('origin_Airport_ID', this.state.airport);
   params.append('City', this.state.city);
   params.append('Country', this.state.country);
   params.append('IP_Address', '83.53.163.138');

   axios.post("backend/userCreation.php", params, {
       headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    }
  )
  .then(function (response) {
    console.log(response);
  })
  .catch(function (error) {
    console.log(error);
  });
}


handleFirstChange(e) {
   this.setState({firstName: e.target.value});
}
handleLastChange(e) {
   this.setState({lastName: e.target.value});
}
handleEmailChange(e) {
   this.setState({emailAdress: e.target.value});
}
handlePassChange(e) {
   this.setState({password: e.target.value});
}
handleAirportChange(e) {
   this.setState({airport: e.target.value});
}
handleCityChange(e) {
   this.setState({city: e.target.value});
}
handleCountryChange(e) {
   this.setState({country: e.target.value});
}



  render() {
    return (
 <div className="form_container">
  <Grid columns={2} stretched container stackable >
    <Grid.Column width={5}>
       <Form>
           <Form.Field>
              <label>First Name</label>
              <input placeholder='First Name...' onChange={this.handleFirstChange.bind(this)} />
            </Form.Field>
            <Form.Field>
              <label>Last Name</label>
              <input placeholder='Last Name...' onChange={this.handleLastChange.bind(this)} />
            </Form.Field>
            <Form.Field>
              <label>Email Adress</label>
              <input placeholder='Email...' onChange={this.handleEmailChange.bind(this)} />
            </Form.Field>
            <Form.Field>
              <label>Password</label>
              <input placeholder='Password...'onChange={this.handlePassChange.bind(this)} />
            </Form.Field>
      </Form>
    </Grid.Column>
    <Grid.Column width={5}>
       <Form>
             <Form.Field>
              <label>City</label>
              <input placeholder='Enter City Name...'onChange={this.handleCityChange.bind(this)} />
            </Form.Field>
            <Form.Field>
              <label>Country</label>
              <input placeholder='Enter Country Name...' onChange={this.handleCountryChange.bind(this)}/>
            </Form.Field>
            <Form.Field>
              <label>Origin Airpot</label>
              <input placeholder='Enter Airport Id...' onChange={this.handleAirportChange.bind(this)}/>
            </Form.Field>
            <Form.Field>
              <Checkbox label='I agree to the Terms and Conditions' />
            </Form.Field>
      </Form>
      <Button className="submit" type='submit' onClick = {this.makeUser.bind(this)}>Submit</Button>
    </Grid.Column>
  </Grid>
      
  </div>




      
    );
  }
}

export default CreatePage;