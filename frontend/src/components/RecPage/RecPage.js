import React, { Component } from 'react';
import { Card, Container, Form} from 'semantic-ui-react'
import  axios from 'axios';
import './RecPage.css';
import src from './default.jpg';


class RecPage extends Component {


 state = { 
  user: '',
  month: '',
  minT:'',
  maxT:'',
  minP: '',
  maxP: '',
  minLodge: '',
  maxLodge: '',
  minMeal: '',
  maxMeal: '',
  minOcean: '',
  maxOcean: '',
  minLake: '',
  maxLake: '',
  country: '',
  adv: false
 }


handlemonthChange(e) {
   this.setState({month: e.target.value}); //TODO: Change to farenheit, miles to M
}

handleminTChange(e) {
   this.setState({minT: e.target.value}); //TODO: Change to farenheit, miles to M
}
handlemaxTChange(e) {
   this.setState({maxT: e.target.value}); //TODO: Change to farenheit, miles to M

}

handleminPChange(e) {
   this.setState({minP: e.target.value}); //TODO: Change to farenheit, miles to M

}
handlemaxPChange(e) {
   this.setState({maxP: e.target.value}); //TODO: Change to farenheit, miles to M

}

handleminLodgeChange(e) {
   this.setState({minMeal: e.target.value});

}
handlemaxLodgeChange(e) {
   this.setState({maxMeal: e.target.value});

}


handleminMealChange(e) {
   this.setState({minMeal: e.target.value});

}
handlemaxMealChange(e) {
   this.setState({maxMeal: e.target.value});

}
handleminOceanChange(e) {
   this.setState({minOcean: e.target.value});

}
handlemaxOceanChange(e) {
   this.setState({maxOcean: e.target.value});

}


handleminLakeChange(e) {
   this.setState({minLake: e.target.value});

}
handlemaxLakeChange(e) {
   this.setState({maxLake: e.target.value});

}

handleCountryChange(e) {
   this.setState({country: e.target.value});

}

handleAdvChange(e) {
   let current = this.state.adv;
   this.setState({adv: !current});
}



makePreference(e){
   console.log("Creating Preference...");
  
   var params = new URLSearchParams();
   params.append('UserID', 1);
   params.append('Travel_Month', this.state.month);

   params.append('MIN_Temp', this.state.minT);
   params.append('MAX_Temp', this.state.maxT);
   params.append('MIN_Precipiation', this.state.minP);
   params.append('MAX_Precipiation', this.state.maxP);
   params.append('MIN_Lodging_Cost', this.state.minLodge);
   params.append('MAX_Lodging_Cost', this.state.maxLodge);
   params.append('MIN_Meal_Cost', this.state.minMeal);
   params.append('MAX_Meal_Cost', this.state.maxMeal);

   params.append('Travel_Advisories', this.state.adv);
   params.append('MIN_Distance_To_Ocean', this.state.minOcean);
   params.append('MAX_Distance_To_Ocean', this.state.maxOcean);

   params.append('MIN_Distance_To_Lake', this.state.minLake);
   params.append('MAX_Distance_To_Lake', this.state.maxLake);
   params.append('Country', this.state.country);


   axios.post("backend/addPreference.php", params, {
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

  render() {
    return (
    <div>
       <Container>
      <Form>
        <Form.Group widths='equal'>
          <Form.Input label='Country'  onChange={this.handleCountryChange.bind(this)} />
          <Form.Input label='Min Temp (F)'  onChange={this.handleminTChange.bind(this)} />
          <Form.Input label='Max Temp (F)'  onChange={this.handlemaxTChange.bind(this)} />

          <Form.Input label='Min Percipitation'  onChange={this.handleminPChange.bind(this)} />
          <Form.Input label='Max Percipitation'  onChange={this.handlemaxPChange.bind(this)} />
        </Form.Group>
        <Form.Group widths='equal'>
		  <Form.Input label='Min Lodgin Cost'  onChange={this.handleminLodgeChange.bind(this)} />
            <Form.Input label='MaxLodgin Cost'onChange={this.handlemaxLodgeChange.bind(this)} />

		    <Form.Input label='Min Meal Cost'  onChange={this.handleminMealChange.bind(this)} />
            <Form.Input label='Max Minimum Meal Cost'  onChange={this.handlemaxMealChange.bind(this)} />
          </Form.Group>
       <Form.Group widths='equal'>

          <Form.Input label='Min Distance from Lake (mi)'   onChange={this.handleminOceanChange.bind(this)}/>
          <Form.Input label='Max Distance from Lake (mi)'   onChange={this.handlemaxOceanChange.bind(this)}/>

          <Form.Input label='Min Distance from Ocean (mi)'   onChange={this.handleminLakeChange.bind(this)}/>
          <Form.Input label='Max Distance from Ocean (mi)'   onChange={this.handlemaxLakeChange.bind(this)}/>

          <Form.Checkbox label='List countries With Travel Advisories?'  onChange={this.handleAdvChange.bind(this)} checked = {this.state.adv}/>
        </Form.Group>
        <Form.Group inline>
          
          <Form.Button onClick = {this.makePreference.bind(this)}> Submit </Form.Button>
        </Form.Group>

      </Form>
</Container>


<Container>
    <Card.Group className="cards" itemsPerRow={4}>
    <Card color='red' image={src} />
    <Card color='orange' image={src} />
    <Card color='yellow' image={src} />
    <Card color='olive' image={src} />
    <Card color='green' image={src} />
    <Card color='teal' image={src} />
    <Card color='blue' image={src} />
    <Card color='violet' image={src} />
    <Card color='purple' image={src} />
    <Card color='pink' image={src} />
    <Card color='brown' image={src} />
    <Card color='grey' image={src} />
  </Card.Group>
  </Container>
  </div>

    );
  }
}

export default RecPage;
