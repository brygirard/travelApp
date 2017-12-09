import React, { Component } from 'react';
import { Button, Form } from 'semantic-ui-react'
import './LoginPage.css';
import axios from 'axios';
import {setUser} from "../red.js"
import { Link } from 'react-router-dom';
import { connect } from 'react-redux';









const LoginForm = (props) => (
  <div className="form_container">
    <Form>
      <Form.Field>
        <label>Email</label>
         <input placeholder='example@example.com' onChange = {props.handleEmailChange} />
      </Form.Field>
      <Form.Field>
        <label>Password</label>
        <input placeholder='Password' onChange = {props.handlePassChange} />
      </Form.Field>
       <Button onClick = {props.verifyUser} type='submit'>Log In</Button>
      <p className="register">Need an account? Register Here</p>
    </Form>
  </div>
)





class LoginPage extends Component {
constructor(props) {
  super(props);
  this.state = {
      email: '',
       pass: ''
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
      failLogIn(response);
    }else{
      logIn(response.data[0]);
    }
  })
  .catch(function (error) {
    console.log(error);
  });


}


  render() {
    return (
      <LoginForm 
        handlePassChange = {this.handlePassChange.bind(this)} 
        handleEmailChange = {this.handleEmailChange.bind(this)}
        verifyUser = {this.verifyUser.bind(this)}
      />
    );
  }

    const { loggingIn } = state.authentication;
    return {
        loggingIn
    };
  }

}


function mapStateToProps(state) {
    const { loggingIn } = state.authentication;
    return {
        loggingIn
    };
}

export default LoginPage;
