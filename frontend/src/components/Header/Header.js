import React, { Component } from 'react';
import { Menu } from 'semantic-ui-react'
import 'semantic-ui-css/semantic.min.css';

import './Header.css';

const Logo = () => (
    <div>
         Desination Planner
    </div>
)

class Header extends Component {
  state = { activeItem: 'home' }

  handleItemClick = (e, { name }) => this.setState({ activeItem: name })

  render() {
    const { activeItem } = this.state

    return (
      <Menu inverted>
        <Menu.Item header><Logo/></Menu.Item>
        <Menu.Item name='home' active={activeItem === 'home'} onClick={this.handleItemClick} href="/" />
        <Menu.Item name='browse' active={activeItem === 'browse'} onClick={this.handleItemClick} href="/browse"/>
        <Menu.Item name='recommended' active={activeItem === 'rec'} onClick={this.handleItemClick} href="/rec" />
        <Menu.Menu position='right'>
            <Menu.Item name='login' active={activeItem === 'login'} onClick={this.handleItemClick} href="/login" />
            <Menu.Item name='create' active={activeItem === 'create'} onClick={this.handleItemClick} href="/create" />
        </Menu.Menu>
      </Menu>
    )
  }
}

export default Header;
