import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import AdminDisplay from './AdminDisplay';

class AdminContainer extends Component {
    static propTypes = {
        apiRecipesLoaded: PropTypes.number,
        apiRecipesNotLoaded: PropTypes.number,
        lastApiRecipeLoaded: PropTypes.string,
        nextApiRecipeToLoad: PropTypes.string
    };

    state = {
        //
    };

    componentDidMount() {
        this.setState({apiRecipesLoaded: this.props.apiRecipesLoaded})
    }

    handleTest = () => {
        console.log('pew pew');
    };

    handleGetInitialState = () => {
        // fetch from backend
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
                <AdminDisplay
                    apiRecipesLoaded={this.state.apiRecipesLoaded}
                />
            </div>
        )
    }
}

export default AdminContainer;

if (document.getElementById('admin_container')) {
    const element = document.getElementById('admin_container');
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<AdminContainer {...props}/>, element);
}
