import React, { Component } from 'react';
import axios from 'axios';
import { Grid, Button, Header, Modal, Form, Container, Input, Card, Icon, Image, Label, List} from 'semantic-ui-react';
import InfiniteCalendar from 'react-infinite-calendar';
import 'react-infinite-calendar/styles.css'; // Make sure to import the default stylesheet

import {connect} from "react-redux";

import './ProfilePage.css';


const ProfileCard = () => (
  <Card centered style={{height:'500px', textAlign:'center'}}>
    <Image src='https://react.semantic-ui.com/assets/images/avatar/large/elliot.jpg' />
    <Card.Content>
      <Card.Header>
        Welcome
      </Card.Header>
      <Card.Meta>
        <span className='date'>
          Joined in 2017
        </span>
      </Card.Meta>
    </Card.Content>
    <Card.Content extra>
      <a>
        <Icon name='log out' />
        Logout
      </a>
    </Card.Content>
  </Card>
)



class ProfilePage extends Component {
  state = {
    user: 1,
    open: false,
    oAir: '',
    dAir: '',
    startD: '',
    endD: '',
    lEst: '',
    fEst: '',
    mEst: '',
    other: '',


    openC: false,
    dboAir: '',
    dbdAir: '',
    dbstartD: '',
    dbendD: '',
    dblEst: '',
    dbfEst: '',
    dbmEst: '',
    dbother: ''
  }






handleoAirChange(e) {
   this.setState({oAir: e.target.value});
}

handldAirChange(e) {
   this.setState({dAir: e.target.value});
}
handlestartDChange(e) {
   this.setState({startD: e.target.value}); 

}

handleendDChange(e) {
   this.setState({endD: e.target.value}); 

}


handlelodgeEstChange(e) {
   this.setState({lEst: e.target.value}); 

}

handlefoodEstChange(e) {
   this.setState({fEst: e.target.value});

}
handlemiscEstChange(e) {
   this.setState({mEst: e.target.value});

}

handleotherChange(e) {
   this.setState({other: e.target.value});
}


openCancun(e){
  console.log("Opening Cancun Chicago Info...")
  this.setState({open: true});

}

closeCancun(e){
   this.setState({open: false});
   console.log("Closing...");


   console.log("Updating Scenario...")
   var params = new URLSearchParams();
   params.append('UserID', this.state.user);
   params.append('orgAirport', this.state.oAir);
   params.append('desAirport', this.state.dAir);
   params.append('lodgeCostEstimate', this.state.lEst);
   params.append('foodCostEstimate', this.state.fEst);
   params.append('miscCostEstimate', this.state.mEst);
   params.append('userLinks', this.state.other);
   params.append('UserDateStart', this.state.startD);
   params.append('UserDateEnd', this.state.endD);


  axios.post("backend/.php", params, {
       headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    }
  )
  .then(function (response) {
    console.log(response);
    if(response.data === null){
      //failLogIn(response);
    }else{
      //logIn(response.data[0]);
    }
  })
  .catch(function (error) {
    console.log(error);
  });



}


openChicago(e){
  console.log("Getting Chicago Info...")
  this.setState({openC: true});
 
}

closeChicago(e){
   this.setState({openC: false});
   

}

  render() {
    console.log(this.props.user);
    return (
  <Grid columns={2} verticalAlign='middle' stretched container stackable >
    <Grid.Row>
      <Grid.Column width={5}>
       <ProfileCard/>
        </Grid.Column>
         <Grid.Column width={11} >
           <Grid columns={1} textAlign='center' verticalAlign='middle'  >
             <Grid.Row>
                  <Header size='huge'>Your Destinations</Header>

            </Grid.Row>
             <Grid.Row>



                 
    <List divided verticalAlign='middle' size='huge' style={{height:"450px"}} >
    
    <List.Item onClick = {this.openCancun.bind(this)}>
      <Image avatar src='https://media-cdn.tripadvisor.com/media/photo-s/09/58/8c/3f/playa-lancheros.jpg' />
      <List.Content>
        <List.Header as='a'>Cancun, Mexico</List.Header>
      </List.Content>
        
      <List.Content floated='right' style={{paddingTop:'0.25em'}}>
            <Label >
                <Icon name='trash' />
            </Label>
      </List.Content>
        
    </List.Item>
    
    <List.Item onClick = {this.openChicago.bind(this)}>
      <Image avatar src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Chicago_skyline%2C_viewed_from_John_Hancock_Center.jpg/500px-Chicago_skyline%2C_viewed_from_John_Hancock_Center.jpg' />
      <List.Content>
        <List.Header as='a'>Chicago, Illinois</List.Header>
      </List.Content>
        
      <List.Content floated='right' style={{paddingTop:'0.25em'}}>
            <Label >
                <Icon name='trash' />
            </Label>
      </List.Content>
        
    </List.Item>
        
    <List.Item onClick = {this.openCancun.bind(this)}>
      <Image avatar src='http://www.telegraph.co.uk/content/dam/Travel/Destinations/Europe/France/Paris/paris-attractions-xlarge.jpg' />
      <List.Content>
        <List.Header as='a'>Paris, France</List.Header>
      </List.Content>
        
      <List.Content floated='right' style={{paddingTop:'0.25em'}}>
            <Label >
                <Icon name='trash' />
            </Label>
      </List.Content>
    </List.Item>
        
  </List>

            </Grid.Row>
              <Modal open = {this.state.open}>
                 <Modal.Header>Cancun, Mexico</Modal.Header>
                 <Container fluid>
                       <Form>
        <Form.Group widths='equal'>
          <Form.Input value = {this.state.oAir} label='Origin Airport' placeholder='Enter Airport...' onChange = {this.handleoAirChange.bind(this)}/>
          <Form.Input value = {this.state.dAir} label='Destination Airport' placeholder='Enter Airport...' onChange = {this.handldAirChange.bind(this)}/>
          <Form.Input value = {this.state.startD} label='Start Date' placeholder='YYYY-MM-DD' onChange = {this.handlestartDChange.bind(this)}/>
          <Form.Input value = {this.state.endD} label='End Date' placeholder='YYYY-MM-DD' onChange = {this.handleendDChange.bind(this)}/>
        </Form.Group>

        <Form.Group widths='equal'>
               <Form.Input value = {this.state.lEst} label='Loding Cost Estimate' placeholder='$' onChange = {this.handlelodgeEstChange.bind(this)}/>
               <Form.Input value = {this.state.fEst} label='Food Cost Estimate' placeholder='$' onChange = {this.handlefoodEstChange.bind(this)}/>
               <Form.Input value = {this.state.mEst} label='Misc Cost Estimate' placeholder='$'onChange = {this.handlemiscEstChange.bind(this)} />
        </Form.Group>
        <Form.TextArea value = {this.state.other} label='Links and Notes' placeholder='Tell us more about your trip...' onChange = {this.handleotherChange.bind(this)}/>
        <Form.Button onClick = {this.closeCancun.bind(this)}>Save</Form.Button>
  </Form>
                 </Container>
  </Modal>




  <Modal open = {this.state.openC}>
      <Modal.Header>Chicago, Illinois</Modal.Header>
                 <Container fluid>
                       <Form>
        <Form.Group widths='equal'>
          <Form.Input value = 'oha' label='Origin Airport' placeholder='Enter Airport...' onChange = {this.handleoAirChange.bind(this)}/>
          <Form.Input value = 'lax' label='Destination Airport' placeholder='Enter Airport...' onChange = {this.handldAirChange.bind(this)}/>
          <Form.Input value = '0000-00-00' label='Start Date' placeholder='YYYY-MM-DD' onChange = {this.handlestartDChange.bind(this)}/>
          <Form.Input value = '0000-00-00' label='End Date' placeholder='YYYY-MM-DD' onChange = {this.handleendDChange.bind(this)}/>
        </Form.Group>

        <Form.Group widths='equal'>
               <Form.Input value = '500' label='Loding Cost Estimate' placeholder='$' onChange = {this.handlelodgeEstChange.bind(this)}/>
               <Form.Input value = '250' label='Food Cost Estimate' placeholder='$' onChange = {this.handlefoodEstChange.bind(this)}/>
               <Form.Input value = '300' label='Misc Cost Estimate' placeholder='$'onChange = {this.handlemiscEstChange.bind(this)} />
        </Form.Group>
        <Form.TextArea value = {this.state.other} label='Links and Notes' placeholder='Tell us more about your trip...' onChange = {this.handleotherChange.bind(this)}/>
        <Form.Button onClick = {this.closeChicago.bind(this)}>Save</Form.Button>
  </Form>
                 </Container>
  </Modal>



        </Grid>

    </Grid.Column>

    </Grid.Row>
        
  </Grid>
    );
  }

 }
/*
 function mapStateToProps(state) {
  return {
    user: store.user.user
  };
 }
 */


 

export default (ProfilePage);
