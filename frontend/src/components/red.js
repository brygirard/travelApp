import { createStore } from 'redux'


export function setUser(id){
return{
	type: "SET_USER",
	payload: id,
   }
}

const reducer = function(state, action){
  if(action.type === "SET_USER"){   // action LOG, sets state to UserID
    state = action;
  }
  if(action.type === "LOGOUT"){   // action LOG, sets state to UserID
    state = -1;
  }
  return state;
}

export default createStore(reducer);