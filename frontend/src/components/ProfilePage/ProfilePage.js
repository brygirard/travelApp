import React, { Component } from 'react';
import { Grid, Button, List, Header, Modal, Form, Container, Input} from 'semantic-ui-react'
import { Card, Icon, Image, Label } from 'semantic-ui-react'

import InfiniteCalendar from 'react-infinite-calendar';
import 'react-infinite-calendar/styles.css'; // Make sure to import the default stylesheet

import {connect} from "react-redux"

import './ProfilePage.css';





const GridLayout = () => (
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
                 
                 <ThreadList/>
            </Grid.Row>
            <ModalModalExample/>
        </Grid>

    </Grid.Column>

    </Grid.Row>
        
  </Grid>
)

const ThreadList = () => (
  <List divided verticalAlign='middle' size='huge' style={{height:"450px"}} >
    
    <List.Item>
      <Image avatar src='https://media-cdn.tripadvisor.com/media/photo-s/09/58/8c/3f/playa-lancheros.jpg' />
      <List.Content>
        <List.Header as='a'>Cancun, Mexio</List.Header>
      </List.Content>
        
      <List.Content floated='right' style={{paddingTop:'0.25em'}}>
            <Label >
                <Icon name='trash' />
            </Label>
      </List.Content>
        
    </List.Item>
    
    <List.Item>
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
        
    <List.Item>
      <Image avatar src='http://www.telegraph.co.uk/content/dam/Travel/Destinations/Europe/France/Paris/paris-attractions-xlarge.jpg' />
      <List.Content>
        <List.Header as='a'>Paris, Frace</List.Header>
      </List.Content>
        
      <List.Content floated='right' style={{paddingTop:'0.25em'}}>
            <Label >
                <Icon name='trash' />
            </Label>
      </List.Content>
    </List.Item>
        
  </List>
)

const ProfileCard = () => (
  <Card centered style={{height:'500px', textAlign:'center'}}>
    <Image src='https://react.semantic-ui.com/assets/images/avatar/large/elliot.jpg' />
    <Card.Content>
      <Card.Header>
        Matthew
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

const ModalModalExample = () => (
  <Modal trigger={<Button>Show Modal</Button>}>
    <Modal.Header>City Name</Modal.Header>
     <Container fluid>
      <Sform className = "modForms"/>
     </Container>
  </Modal>
)


const Sform = () => (
   <Form>
        <Form.Group widths='equal'>
          <Form.Input label='Origin Airport' placeholder='Enter Airport...' />
          <Form.Input label='Destination Airport' placeholder='Enter Airport...' />
          <Form.Input label='Start Date' placeholder='YYYY-MM-DD' />
          <Form.Input label='End Date' placeholder='YYYY-MM-DD' />

        </Form.Group>

        <Form.Group widths='equal'>
               <Form.Input label='Loding Cost Estimate' placeholder='$' />
               <Form.Input label='Food Cost Estimate' placeholder='$' />
               <Form.Input label='Misc Cost Estimate' placeholder='$' />
        </Form.Group>
        <Form.TextArea label='Links and Notes' placeholder='Tell us more about your trip...' />
        <Form.Button>Save</Form.Button>
  </Form>

)


class ProfilePage extends Component {
  state = {
    user: -1
  }

  render() {
    console.log(this.props.user);
    return (
        <GridLayout/>
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
