import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import AdminDisplay from './AdminDisplay';
import AdminAjaxService from './AdminAjaxService';

class AdminContainer extends Component {
    state = {
        apiRecipesLoaded: 0,
        apiRecipesNotLoaded: 0,
        lastApiRecipeLoaded: '',
        nextApiRecipeToLoad: '',
        renderDisplay: false
    };

    componentDidMount() {
        this.handleGetInitialState();
    }

    handleGetInitialState = () => {
        // return AdminAjaxService.getApiRecipeData()
        fetch('api/get/apiHealthData')
            .then((resp) => resp.json())
            .then(data => {
                this.setState((prevState) => {
                    return {...data, renderDisplay: true}
                });
            })
            .catch(() => {
                console.log('error');
            })
    };

    handleGetNewRecipe = () => {
        // trigger job
    };

    handleGetNewRecipePage = () => {
        // trigger job
    };


    render () {
        return (
            <div>
                {this.state.renderDisplay &&
                    <AdminDisplay
                        apiRecipesLoaded={this.state.apiRecipesLoaded}
                        apiRecipesNotLoaded={this.state.apiRecipesNotLoaded}
                        lastApiRecipeLoaded={this.state.lastApiRecipeLoaded}
                        nextApiRecipeToLoad={this.state.nextApiRecipeToLoad}
                    />
                }
            </div>
        )
    }
}

export default AdminContainer;

if (document.getElementById('admin_container')) {
    const element = document.getElementById('admin_container');
    ReactDOM.render(<AdminContainer/>, element);
}
