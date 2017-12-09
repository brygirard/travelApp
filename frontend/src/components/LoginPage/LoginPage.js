import React, { Component } from 'react';
import { Button, Form, Card, Image, Icon, List, Modal } from 'semantic-ui-react'
import './LoginPage.css';
import axios from 'axios';
import {setUser} from "../red.js"
import { Link } from 'react-router-dom';
import { connect } from 'react-redux';





class LoginPage extends Component {
constructor(props) {
  super(props);
  this.state = {
      email: '',
       pass: '',
       logged: false,
       firstName: '',
       lastName: '',
       oAirport: '',

  };
}

handleEmailChange(e) {
   this.setState({email: e.target.value});
}
handlePassChange(e) {
   this.setState({pass: e.target.value});
}



verifyUser(){

   console.log("Loggin In...")
   var params = new URLSearchParams();
   params.append('user', this.state.email);
   params.append('pass', this.state.pass);

  let self = this;
  console.log(this.state.email);
  console.log(this.state.pass);
  axios.post("backend/login.php", params, {
       headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    }
  )
  .then(function (response) {
    console.log(response);
    if(response.data === null){
      console.log("Wrong name/pass")
    }else{
      self.setState({logged: true});
      console.log("Logged in");
    }
  })
  .catch(function (error) {
    console.log(error);
  });
}



  render() {


    return (
        <div className="form_container">
    <Form>
      <Form.Field>
        <label>Email</label>
         <input placeholder='example@example.com' onChange = {this.handleEmailChange.bind(this)} />
      </Form.Field>
      <Form.Field>
        <label>Password</label>
        <input placeholder='Password' onChange = {this.handlePassChange.bind(this)} />
      </Form.Field>
       <Button onClick = {this.verifyUser.bind(this)} type='submit'>Log In</Button>
       <p className="register">Need an account? Register Here</p>
    </Form>

   <Modal open = {this.state.logged} basic size='small'>
    <Modal.Content>
      <p>Sucessfully Logged In</p>
    </Modal.Content>
    <Modal.Actions>
      <Button color='green' inverted href = '/browse'>
        <Icon name='checkmark' /> Continue
      </Button>
    </Modal.Actions>
  </Modal>



  </div>











  );

}





/*
if(this.state.logged){
  return(
<Card centered style={{height:'500px', textAlign:'center'}}>
    <Image src='https://react.semantic-ui.com/assets/images/avatar/large/elliot.jpg' />
    <Card.Content>
      <Card.Header>
        Welcome {this.state.firstName}
      </Card.Header>
      <Card.Meta>
        <span className='date'>
          Joined in 2017
        </span>
      </Card.Meta>
    </Card.Content>
 <Card.Content>
  <List>
           <List.Item>City: {this.state.city}</List.Item>
           <List.Item>Area: {this.state.area}</List.Item>
           <List.Item>Country: {this.state.country}</List.Item>
           <List.Item>Timezone: {this.state.timezone}</List.Item>
        </List>
 </Card.Content>

    <Card.Content extra>
      <a>
        <Icon name='log out' />
        Logout
      </a>
    </Card.Content>


  </Card>);
  */

}

export default LoginPage;
