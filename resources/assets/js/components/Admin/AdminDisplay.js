/**
 * Admin Display Component
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

import React from 'react'
import PropTypes from 'prop-types';

const AdminDisplay = props => {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header"><h4>Admin Dashboard</h4></div>
                        <div className="card-body">
                            <h5>F2F Integration Job Health</h5>
                        </div>
                        <div className="card-header">API Recipes Loaded: Total</div>
                        <div className="card-body">
                            {props.apiRecipesLoaded}
                        </div>
                        <div className="card-header">API Recipes Staged: Total</div>
                        <div className="card-body">
                            {props.apiRecipesNotLoaded}
                        </div>
                        <div className="card-header">API Recipes Not Loaded: Errored</div>
                        <div className="card-body">
                            {props.apiRecipesErrored}
                        </div>
                        <div className="card-header">API Page Data:</div>
                        <div className="card-body">
                            {'Estimated pages remaining: '}{4824 - props.nextPage}
                        </div>
                        <div className="card-body">
                            {'Current Page: '}{props.currentPage}
                        </div>
                        <div className="card-body">
                            {'Next Page: '}{props.nextPage}
                        </div>
                        <div className="card-header">Last API Recipe Loaded:</div>
                        <div className="card-body">
                            {props.lastApiRecipeLoaded}
                        </div>
                        <div className="card-header">Next API Recipe To Load:</div>
                        <div className="card-body">
                            {props.nextApiRecipeToLoad}
                        </div>
                        <div className="card-header">Integration Job Health:</div>
                        <div className="card-body">
                            {'Last Successful Recipe Job Run: '}<br />
                            {props.recipeJobHealth}
                        </div>
                        <div className="card-body">
                            {'Last Successful Recipe Data Job Run: '}<br />
                            {props.recipeDataJobHealth}
                        </div>
                        <div className="card-body">
                            {'Logs...'}
                        </div>
                        <div className="card-header">Dashboard Functions</div>
                        <div className="card-body">
                            <button className="btn btn-info btn-lg btn-block" onClick={props.handleRefresh}>Refresh Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

AdminDisplay.propTypes = {
    apiRecipesLoaded: PropTypes.number,
    apiRecipesNotLoaded: PropTypes.number,
    apiRecipesErrored: PropTypes.number,
    lastApiRecipeLoaded: PropTypes.string,
    nextApiRecipeToLoad: PropTypes.string,
    currentPage: PropTypes.number,
    nextPage: PropTypes.number,
    handleRefresh: PropTypes.func,
    recipeJobHealth: PropTypes.string,
    recipeDataJobHealth: PropTypes.string,
};

AdminDisplay.defaultProps = {
    apiRecipesLoaded: 0,
    apiRecipesNotLoaded: 0,
    apiRecipesErrored: 0,
    lastApiRecipeLoaded: '',
    nextApiRecipeToLoad: '',
    currentPage: 0,
    nextPage: 0,
    recipeJobHealth: '',
    recipeDataJobHealth: '',
};

export default AdminDisplay;
