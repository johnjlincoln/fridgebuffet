/**
 * Admin Container Component
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import AdminDisplay from './AdminDisplay';
import AdminAjaxService from './AdminAjaxService';

class AdminContainer extends Component {
    state = {
        apiRecipesLoaded: 0,
        apiRecipesNotLoaded: 0,
        apiRecipesErrored: 0,
        lastApiRecipeLoaded: '',
        nextApiRecipeToLoad: '',
        currentPage: 0,
        nextPage: 0,
        recipeJobHealth: '',
        recipeDataJobHealth: '',
        renderDisplay: false
    };

    componentDidMount() {
        this.handleGetData();
    }

    handleGetData = () => {
        // return AdminAjaxService.getApiRecipeData()
        fetch('api/get/apiHealthData')
            .then((resp) => resp.json())
            .then(data => {
                this.setState(() => {
                    return {...data, renderDisplay: true}
                });
            })
            .catch(() => {
                console.log('error');
            })
    };

    handleRefresh = () => {
        this.handleGetData();
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
                        apiRecipesErrored={this.state.apiRecipesErrored}
                        lastApiRecipeLoaded={this.state.lastApiRecipeLoaded}
                        nextApiRecipeToLoad={this.state.nextApiRecipeToLoad}
                        currentPage={this.state.currentPage}
                        nextPage={this.state.nextPage}
                        recipeJobHealth={this.state.recipeJobHealth}
                        recipeDataJobHealth={this.state.recipeDataJobHealth}
                        handleRefresh={this.handleRefresh}
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
