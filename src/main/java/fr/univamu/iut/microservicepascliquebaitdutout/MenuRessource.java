package fr.univamu.iut.microservicepascliquebaitdutout;

import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;

import java.util.Date;

@Path("/menus")
@Produces(MediaType.APPLICATION_JSON)
@Consumes(MediaType.APPLICATION_JSON)
public class MenuRessource {

    @Inject
    private MenuService service;

    @GET
    public Response getAll() {
        return Response.ok(service.findAll()).build();
    }

    @GET @Path("/{id}")
    public Response getById(@PathParam("id") int id) {
        Menu m = service.findById(id);
        if (m == null) return Response.status(404).build();
        return Response.ok(m).build();
    }

    @POST
    public Response create(Menu m) {
        m.setDateCreation(new Date());
        return Response.status(201).entity(service.create(m)).build();
    }

    @PUT @Path("/{id}")
    public Response update(@PathParam("id") int id, Menu m) {
        m.setId(id);
        return Response.ok(service.update(m)).build();
    }

    @DELETE @Path("/{id}")
    public Response delete(@PathParam("id") int id) {
        service.delete(id);
        return Response.noContent().build();
    }

    @POST @Path("/{id}/plats/{platId}")
    public Response addPlat(@PathParam("id") int id, @PathParam("platId") int platId) {
        return Response.ok(service.addPlatToMenu(id, platId)).build();
    }

    @DELETE @Path("/{id}/plats/{platId}")
    public Response removePlat(@PathParam("id") int id, @PathParam("platId") int platId) {
        return Response.ok(service.removePlatFromMenu(id, platId)).build();
    }
}